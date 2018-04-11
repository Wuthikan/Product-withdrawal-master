<?php

namespace DurianSoftware\Http\Controllers\BackOffice\Setting;

use DurianSoftware\Http\Controllers\Controller;

use Excel;
use Hash;
use Lang;
use Response;
use Session;
use Validator;
use Illuminate\Http\Request;
use DurianSoftware\Http\Requests\BackOffice\User\UserRequest;

use DurianSoftware\Models\Date;
use DurianSoftware\Models\Department;
use DurianSoftware\Models\DepartmentRoleUser;
use DurianSoftware\Models\Role;
use DurianSoftware\Models\User;

class UserController extends Controller
{
    public $perPage = 15;

    public function __construct()
    {
        session(['client_id' => 1]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // search จาก field ไหนก็ได้ ทำเป็นแบบ OR ให้มี %search_term% ก็เจอ
        $data_search = '';

        $query = User::withTrashed()
            ->whereClientId(Session::get('client_id'));

        if ($request->has('search')) {
            $data_search = $request->search;
            $query->where(function ($q) use ($data_search) {
                $q->where('member_number', 'LIKE', "%{$data_search}%");
                $q->orWhere('first_name', 'LIKE', "%{$data_search}%");
                $q->orWhere('last_name', 'LIKE', "%{$data_search}%");
                $q->orWhere('nick_name', 'LIKE', "%{$data_search}%");
                $q->orWhere('gender', 'LIKE', "%{$data_search}%");
                $q->orWhere('email', 'LIKE', "%{$data_search}%");
                $q->orWhere('phone', 'LIKE', "%{$data_search}%");
                $q->orWhere('description_status', 'LIKE', "%{$data_search}%");
            });
        }

        $sort = $request->has('sort') ? $request->sort : 'id';
        $order = $request->has('order') ? $request->order : 'asc';

        $users = $query
            ->orderBy($sort, $order)
            ->paginate($this->perPage);

        return view('backOffice.setting.user.index')
            ->with('users', $users)
            ->with('search', $data_search)
            ->with('sort', $sort)
            ->with('order', $order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['departments'] = Department::whereClientId(Session::get('client_id'))->get();
        $data['roles'] = Role::whereClientId(Session::get('client_id'))->get();

        if ($request->has('id')) {
            $id = $request->id;
            $user = User::find($id);

            $data['permissions'] = DepartmentRoleUser::whereClientId(Session::get('client_id'))
                ->whereUserId($user->id)
                ->get();

            return view('backOffice.setting.user.duplicate')
                ->with('user', $user)
                ->with('data', $data);
        }

        return view('backOffice.setting.user.create')
            ->with('data', $data);
    }

    private function uploadAvatar($file)
    {
        $destination = '/images/backOffice/users/';

        $upload_path = public_path($destination);
        $filename = uniqid().'.jpg';

        $image = $file->move($upload_path, $filename);

        return $destination.$filename;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');

        $clientId = Session::get('client_id');

        $image1 = null;
        $image2 = null;

        if ($request->has('image1')) {
            $image1 = $this->uploadAvatar($request->file('image1'));
        }

        if ($request->has('image2')) {
            // $image2 = $request->file('image2')->store('public/images/back-office/users');
            $image2 = $this->uploadAvatar($request->file('image2'));
        }

        // store
        try {
            $birthDate = Date::InsertStrDate(trim($data['birthdate']));
        } catch (\Exception $e) {
            dd('birthdate', $e->getMessage());
            return back()
                ->with('warning', Lang::get('user.save_unsuccess'))
                ->withInput();
        }

        try {
            $registerDate = Date::InsertStrDate(trim($data['register_date']));
        } catch (\Exception $e) {
            dd('register', $e->getMessage());
            return back()
                ->with('warning', Lang::get('user.save_unsuccess'))
                ->withInput();
        }

        $create_data = [
                'client_id'             => $clientId,
                'birth_date_id'         => $birthDate->id,
                'register_date_id'      => $registerDate->id,
                'member_number'         => trim($data['member_number']),
                'password'              => Hash::make(trim($data['password'])),
                'first_name'            => trim($data['first_name']),
                'last_name'             => trim($data['last_name']),
                'nick_name'             => trim($data['nick_name']),
                'gender'                => trim($data['gender']),
                'email'                 => trim($data['email']),
                'phone'                 => trim($data['phone']),
                'description_status'    => trim($data['description_status']),
                'image_show'            => trim($data['imageShow']),
                'user_right'            => trim($data['userRight']),
                'image1'                => $image1,
                'image2'                => $image2,
            ];

        try {
            $user = User::create($create_data);
        } catch (\Exception $e) {
            dd('create', $e->getMessage(), $create_data);
            return back()
                ->with('warning', Lang::get('user.save_unsuccess'))
                ->withInput();
        }

        $userRelations = [];

        foreach ($data['userPrivilege'] as $department_id => $role_id) {
            array_push($userRelations, [
                'client_id'     => $clientId,
                'user_id'       => $user->id,
                'role_id'       => intval($role_id),
                'department_id' => intval($department_id),
            ]);
        }

        if (count($userRelations) > 0) {
            try {
                DepartmentRoleUser::insert($userRelations);
            } catch (\Exception $e) {
                dd('permissions', $e->getMessage());
                return back()
                    ->with('warning', Lang::get('user.save_unsuccess'))
                    ->withInput();
            }
        }

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('backOffice.setting.user.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::whereClientId(Session::get('client_id'))
            ->whereId($id)
            ->first();

        if ($user==null) {
            return back()
                ->with('warning', Lang::get('alert.delete_before_edit'))
                ->withInput();
            // dd($e->getMessage());
        }

        // dd(storage_path($user->image2), public_path($user->image2), asset($user->image2));

        $data['departments'] = Department::whereClientId(Session::get('client_id'))->get();
        $data['roles'] = Role::whereClientId(Session::get('client_id'))->get();
        $data['permissions'] = DepartmentRoleUser::whereClientId(Session::get('client_id'))
            ->whereUserId($user->id)
            ->get();

        // dd($data['permissions']->where('department_id', 1)[0]->role_id, $data);

        return view('backOffice.setting.user.update')->with([
            'user' => $user,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clientId = Session::get('client_id');

        // dd($request);

        $user = User::whereClientId($clientId)
            ->whereId($id)
            ->first();

        if ($user==null) {
            return back()
                ->with('warning', Lang::get('alert.delete_before_edit'))
                ->withInput();
            // dd($e->getMessage());
        }

        $data = $request->except('_token');

        // store
        try {
            $birthDate = Date::UpdateStrDate(trim($data['birthdate']), $user->birth_date_id);
        } catch (\Exception $e) {
            return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
        }

        try {
            $registerDate = Date::UpdateStrDate(trim($data['register_date']), $user->register_date_id);
        } catch (\Exception $e) {
            return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
        }

        if ($request->has('image1')) {
            try {
                $user->image1 = $request->file('image1')->store('public/images/back-office/users');
            } catch (\Exception $e) {
                return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
            // dd($e->getMessage());
            }
        }

        if ($request->has('image2')) {
            try {
                $user->image2 = $request->file('image2')->store('public/images/back-office/users');
            } catch (\Exception $e) {
                return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
            // dd($e->getMessage());
            }
        }

        try {
            // $user->birth_date_id        = $birthDate->id;
            // $user->register_date_id     = $registerDate->id;
            $user->member_number        = trim($data['member_number']);
            // $user->password              = Hash::make(trim($data['password']));
            $user->first_name           = trim($data['first_name']);
            $user->last_name            = trim($data['last_name']);
            $user->nick_name            = trim($data['nick_name']);
            $user->gender               = trim($data['gender']);
            $user->email                = trim($data['email']);
            $user->phone                = trim($data['phone']);
            $user->description_status   = trim($data['description_status']);
            $user->image_show           = trim($data['imageShow']);
            $user->user_right           = trim($data['userRight']);

            $user->save();
        } catch (\Exception $e) {
            return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
            // dd($e->getMessage());
        }

        foreach ($data['userPrivilege'] as $department_id => $role_id) {
            try {
                DepartmentRoleUser::whereClientId($clientId)
                    ->whereUserId($user->id)
                    ->whereDepartmentId($department_id)
                    ->update(['role_id'=>$role_id]);
            } catch (\Exception $e) {
                // dd($e->getMessage());
                return back()
                    ->with('warning', Lang::get('user.update_unsuccess'))
                    ->withInput();
            }
        }

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()
            ->whereClientId(Session::get('client_id'))
            ->whereId($id)
            ->first();
        if ($user->trashed()) {
            // $user->forceDelete();

            return redirect()
                ->route('backOffice.setting.user.index')
                ->with('warning', Lang::get('user.delete_unsuccess'));
        }

        $user->delete();

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.delete_success'));
    }

    /**
        * Restore the specified resource back to storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function restore($id)
    {
        $user = User::withTrashed()
            ->whereClientId(Session::get('client_id'))
            ->whereId($id)
            ->first();

        if (!$user->trashed()) {
            // $user->forceDelete();

            return redirect()
                ->route('backOffice.setting.user.index')
                ->with('warning', Lang::get('user.restore_unsuccess'));
        }

        $user->restore();

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.restore_success'));
    }

    public function deleteAll(Request $request)
    {
        $deleteId = $request->has('deleteId') ? json_decode($request->deleteId) : [];

        // process the validation
        $validator = Validator::make($deleteId, [
            'deleteId'      => 'array',
            'deleteId.*'    => 'integer',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('warning', Lang::get('alert.none_selected'));
        }

        $ids= array_map('intval', $deleteId);

        try {
            $result = User::whereIn('id', $ids)
                ->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
            return back()
                ->with('warning', Lang::get('user.delete_unsuccess'))
                ->withInput();
        }

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.delete_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        if (!$request->has('isBlock')) {
            return back()->with('warning', Lang::get('user.update_unsuccess'));
        }

        try {
            User::whereClientId(Session::get('client_id'))
                ->whereId($id)
                ->update(['is_block'=>$request->isBlock]);
        } catch (\Exception $e) {
            return back()
                ->with('warning', Lang::get('user.update_unsuccess'))
                ->withInput();
        }

        return redirect()
            ->route('backOffice.setting.user.index')
            ->with('success', Lang::get('alert.update_success'));
    }

    public function excel(Excel $excel)
    {
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv;charset=UTF-8',
                'Content-Encoding'      => 'UTF-8',
                'Content-Disposition' => 'attachment; filename=user.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
        ];

        $users = User::whereClientId(Session::get('client_id'))->get();

        $list[0] = [
            'Member number',
            'First name',
            'Last name',
            'Nick name',
            'Birth date',
            'Register date',
            'Email',
            'Phone',
            'created_at',
            'updated_at',
            'deleted_at'];

        foreach ($users as $user) {
            array_push($list, [
                $user->member_number,
                $user->first_name,
                $user->last_name,
                $user->nick_name,
                $user->birthDate->fullDate,
                $user->registerDate->fullDate,
                $user->email,
                $user->phone,
                $user->created_at,
                $user->updated_at,
                $user->deleted_at]);
        }

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');

            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        // UTF-8 BOM
        echo "\xEF\xBB\xBF";
        //use Illuminate\Support\Facades\Response;
        return Response::stream($callback, 200, $headers);
    }
}
