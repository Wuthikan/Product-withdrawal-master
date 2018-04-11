<?php

namespace DurianSoftware\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use DurianSoftware\Http\Requests\BackOffice\Inquiry\InquiryRequest;
use DurianSoftware\Http\Controllers\Controller;
use DurianSoftware\Models\Inquiry;
use DurianSoftware\Models\FactInquiries;
use DurianSoftware\Models\Product;
use DurianSoftware\Models\Warehouse;
use DurianSoftware\Models\Type;
use DurianSoftware\Date;
use Validator;
use DB;

class InquiryController extends Controller
{

    private $perpage = 10;
    public function __construct()
    {
        $this->client_id = 1;
        if (session()->has('client_id')) {
            $this->client_id = session()->get('client_id');
        }

        $this->inquiry = Inquiry::where('client_id', $this->client_id);

        $this->pendingInquirys = Inquiry::where('client_id', $this->client_id)
                                        ->where('is_approve', null);
        $this->approveInquirys = Inquiry::where('client_id', $this->client_id)
                                        ->where('is_approve', 'approve');
        $this->partialInquirys = Inquiry::where('client_id', $this->client_id)
                                        ->where('is_approve', 'approve')
                                        ->whereColumn('total_quantity', '>', 'total_backlog')
                                        ->where('total_backlog', '>', 0);
        $this->completeInquirys = Inquiry::where('client_id', $this->client_id)
                                        ->where(function ($query) {
                                            $query->where('is_approve', 'approve');
                                            $query->where('total_backlog', 0);
                                        })
                                         ->orWhere(function ($query) {
                                             $query->where('is_approve', 'unapprove');
                                         });
        $this->newReleaseProducts = Product::orderBy('created_at', 'DESC')->limit(10)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($this->newReleaseProducts);
        $newReleaseProducts = $this->newReleaseProducts;
        $status = 'approve';
        if ($request->filled('status')) {
            $status = $request->status;
        }
        if ($status == 'approve') {
            $inquirys = $this->approveInquirys->select();
        } elseif ($status == 'pending') {
            $inquirys = $this->pendingInquirys->select();
        } elseif ($status == 'complete') {
            $inquirys = $this->completeInquirys->select();
        } elseif ($status =='partial') {
            $inquirys = $this->partialInquirys->select();
        }
        // search จาก field ไหนก็ได้ ทำเป็นแบบ OR ให้มี %search_term% ก็เจอ

        $OrderBy = 'desc';
        $Order = 'id';
        if (isset($request->rdoOrder)) {
            $OrderBy = $request->rdoOrder;
        }
        if (isset($request->rdoBy)) {
            $Order = $request->rdoBy;
        }



        if ($request->has('search')&&$request->search) {
            $search = $request->input('search');
        //     $inquiry = $inquiry
        //                     ->where(function ($query) use ($search) {
        //                         $query->orWhere('name', 'LIKE', '%' . $search . '%');
        //                         $query->orWhere('description', 'LIKE', '%' . $search . '%');
        //                     });
            // $inquirys = $inquirys->join('companies', 'dim_companies.id', '=', 'dim_inquiries.company_id')
            // ->where( 'name', 'LIKE', '%'.$search.'%' );
            
            $inquirys = $inquirys->whereHas('companies', function ($query) use ($search) {
                            $query->where('name', 'like', '%'.$search.'%');
            })->orWhere('id', 'LIKE', '%'.$search.'%');

            // dd($inquirys);
        }


        $inquirys = $inquirys
                        ->withTrashed()
                        ->with('companies')
                        ->orderBy($Order, $OrderBy)
                        ->paginate($this->perpage);

        // dd($inquiry);

        return view('backOffice.inquiry.index', compact('inquirys', 'request', 'newReleaseProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $action = route('backOffice.inquiry.store');
        $warehouses = Warehouse::get();
        $types = Type::get();
        if ($request->has('id')) {
            $inquiry = $this->inquiry->find($request->id);
            $this->checkDelete($inquiry);
            $request->merge($inquiry->toArray());
            $request->flash();
            return view('backOffice.inquiry.create', compact('action', 'inquiry', 'warehouses', 'types'));
        }
        return view('backOffice.inquiry.create', compact('action', 'warehouses', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InquiryRequest $request)
    {
        $data = $request->except('_token');
        try {
            $date = Date::InsertStrDate(trim($data['date']));
        } catch (\Exception $e) {
            return back()
                ->with('warning', 'Can\'t Create');
        }
        
        DB::beginTransaction();
        try {
            $total_quantity = 0;

            foreach ($data['products'] as $key => $product) {
                if ($product['id']) {
                    $total_quantity += $product['quantity'];
                }
            }

            $inquiry = Inquiry::create([
                'client_id'             => $this->client_id,
                'date_id'               => $date->id,
                'inquiry_no'            => '', //wait
                'company_id'            => $data['company_id'], // wait
                'branch_id'             => 1, //wait
                'billing_address'       => '', //wait
                'sub_district_id'       => 1, //wait
                'district_id'           => 1, //wait
                'province_id'           => 1, //wait
                'postcode_id'           => 1, //wait
                'total_quantity'        => $total_quantity,
                'total_backlog'         => $total_quantity,
                'remark'                => $data['remark']?$data['remark']:null
            ]);
            $haveProduct = false;
            foreach ($data['products'] as $key => $product) {
                if ($product['id']) {
                    $validator = Validator::make($product, $this->rules(), $this->messages());
                    if ($validator->fails()) {
                        $errors = $validator->errors();
                        // dd($errors);
                        return back()
                        ->withInput()
                        ->with(['errors'=>$errors]);
                    }
                    FactInquiries::create([
                        'client_id'                 => $this->client_id,
                        'date_id'                   => $date->id,
                        'inquiry_id'                => $inquiry->id,
                        'product_id'                => $product['id'],
                        'publisher_id'              => 1, //wait
                        'category_id'               => 1, //wait
                        'platform_id'               => 1, //wait
                        'edition_id'                => 1, //wait
                        'region_id'                 => 1, //wait
                        'product_item_id'           => 1, //wait
                        'unit_id'                   => 1, //watt
                        'product_item_barcodes_id'  => 1, //wait
                        'warehouse_id'              => $product['warehouse_id'],
                        'product_type_id'           => $product['type_id'],
                        'quantity'                  => $product['quantity'],
                        'unit_price'                => $product['unit_price'],
                        'amount'                    => $product['amount'],
                        'remark'                    => $product['remark']
                    ]);
                    $haveProduct = true;
                }
            }

            if (!$haveProduct) {
                $my_errors = 'Please enter product';
                return back()
                        ->withInput()
                        ->withErrors($my_errors);
            }


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('warning', 'Can\'t Create')
                ->withInput();
        }


        return redirect()->route('backOffice.inquiry.index', ['status'=>$request->status])
                        ->with('success', 'Create success');
        // return redirect()->action('backOffice.inquiry.index');
    }

    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'warehouse_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'quantity'=> 'required|numeric',
            'unit_price'=> 'required|numeric',
            'amount'=> 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'id.required'        => 'Please enter inquiry products_id',
            'id.numeric'    => 'Product id. cannot be null.',
            'warehouse_id.required' => 'Please enter inquiry products_warehouse_id',
            'warehouse_id.numeric'    => 'Warehouse id. cannot be null.',
            'type_id.required' => 'Please enter inquiry products_type_id',
            'type_id.numeric'    => 'Type_id id. cannot be null.',
            'quantity.required' => 'Please enter inquiry products_quantity',
            'quantity.numeric'    => 'Quantity id. cannot be null.',
            'amount.required' => 'Please enter inquiry products_amount',
            'amount.numeric'    => 'Amount id. cannot be null.',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backOffice.inquiry.show');
    }

    /**
     * Display the specified resource for printing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        return view('backOffice.inquiry.print');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backOffice.inquiry.update');
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
        return redirect()->action('backOffice.inquiry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inquiry = $this->inquiry;
        $inquiry = $inquiry->withTrashed()->find($id);
        $this->checkDelete($inquiry);
        if ($inquiry->trashed()) {
            $inquiry->forceDelete();
            return redirect()->route('backOffice.inquiry.index')
            ->with('success', 'Force Delete success');
        }
        $inquiry->delete();

        return redirect()->route('backOffice.inquiry.index', ['status'=>$request->status])
                        ->with('success', 'Delete success');
    }
    
    /**
    * Restore the specified resource back to storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function restore(Request $request, $id)
    {
        $inquiry = $this->inquiry;
        $inquiry = $inquiry->withTrashed()->find($id);
        $this->checkDelete($inquiry);
        $inquiry->restore();
        return redirect()->route('backOffice.inquiry.index', ['status'=>$request->status])
                        ->with('success', 'Restore success');
        ;
    }

    private function checkDelete($model)
    {
        if ($model == null) {
            \Session::flash('warning', 'Tag was deleted');
            \App::abort(302, '', ['Location' => route('backOffice.inquiry.index')]);
        }
    }
}
