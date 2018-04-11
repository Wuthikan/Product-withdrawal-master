<?php

namespace DurianSoftware\Http\Controllers\BackOffice\Setting\Product;

use Illuminate\Http\Request;
use DurianSoftware\Http\Controllers\Controller;
use DurianSoftware\Http\Requests\BackOffice\Setting\Product\ProductRequest;
use DurianSoftware\Platform;
use DurianSoftware\Publisher;
use DurianSoftware\Models\General;
use DurianSoftware\Models\Edition;
use DurianSoftware\Models\Product;

class ProductController extends Controller
{
    public $perPage = 15;
    public $uploadPath = 'images/setting/products';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // search จาก field ไหนก็ได้ ทำเป็นแบบ OR ให้มี %search_term% ก็เจอ
        $platforms = Platform::get();
        $publishers = Publisher::get();
        $generals = General::get();
        $editions = Edition::get();

        if ($request->has('searchAll')) {
            $data_search = $request->searchAll;

            $products = Product::where('isbn', 'LIKE', "%{$data_search}%")
                ->orWhere('name', 'LIKE', "%{$data_search}%")
                ->orWhere('description', 'LIKE', "%{$data_search}%")
                ->orWhere('cost', 'LIKE', "%{$data_search}%")
                ->orWhere('suggested_member_price', 'LIKE', "%{$data_search}%")
                ->orWhere('suggested_retail_price', 'LIKE', "%{$data_search}%")
                ->orWhere('page_count', 'LIKE', "%{$data_search}%")
                ->orWhere('weight', 'LIKE', "%{$data_search}%")
                ->orWhere('width', 'LIKE', "%{$data_search}%")
                ->orWhere('depth', 'LIKE', "%{$data_search}%")
                ->orWhere('height', 'LIKE', "%{$data_search}%")
                ->orWhere('reward_points', 'LIKE', "%{$data_search}%")
                ->orWhere('point_redemption_for_free_gift', 'LIKE', "%{$data_search}%")
                ->orWhereHas('category', function ($query) use ($data_search) {
                    $query->Where('name_th', 'like', "%{$data_search}%")
                    ->orWhere('name_en', 'LIKE', "%{$data_search}%");
                })
                ->orWhereHas('shipping', function ($query) use ($data_search) {
                    $query->Where('name', 'like', "%{$data_search}%");
                })
                ->withTrashed()
                ->orderBy('id', 'DESC')
                ->paginate($this->perPage);
        } else {
            $products = Product::withTrashed()->orderBy('id', 'DESC')->paginate($this->perPage);
        }
        return view('backOffice.setting.product.index')->with([
            'products' => $products,
            'platforms' => $platforms,
            'publishers' => $publishers,
            'generals' => $generals,
            'editions' => $editions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $platforms = Platform::get();
        $publishers = Publisher::get();
        $generals = General::get();
        $editions = Edition::get();

        return view('backOffice.setting.product.create')->with([
            'platforms' => $platforms,
            'publishers' => $publishers,
            'generals' => $generals,
            'editions' => $editions
        ]);
        // return view('backOffice.setting.product.unit.price.index');
        // return view('backOffice.setting.product.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // dd($request);
        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->genre = $request->genre;
        $product->rating = $request->rating;
        $product->number_of_player = $request->number_of_player;
        $product->publisher_id = $request->publisher_id;
        

        if ($product->save()) {
            // Fact platform
            $product->platform()->sync($request->platforms);
            // Fact edition
            $product->edition()->sync($request->edition);

            if ($request->has('new_edition') && !empty($request->new_edition)) {
                $edition = Edition::create([
                    'name' => $request->new_edition
                ]);
                $product->edition()->sync([$edition->id]);
            }

            // Upload pdf file
            if ($request->hasFile('imageProduct')) {
                $file = $request->file('imageProduct');

                $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
                $destination_path = storage_path($this->uploadPath);
                if ($file->move($destination_path, $fileName)) {
                    $product->image = $this->uploadPath . '/' . $fileName;
                }
            }
            \Session::flash('success', 'Create successful!');
        } else {
            \Session::flash('error', 'Create error!');
        }
        return redirect()->route('backOffice.setting.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backOffice.setting.product.show');
    }

    /**
     * Display the specified resource for printing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        return view('backOffice.setting.product.print');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backOffice.setting.product.update');
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
        return redirect()->action('backOffice.setting.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete ครั้งที่สองเป็น forceDelete
        // $model = Model::withTrashed()->where('id', $id)->first();
        // if ($model->trashed()) {
        //     return $model->relationship()->forceDelete();
        // }

        // delete ครั้งแรกทำเป็น soft delete
        // return $model->relationship()->delete();

        return redirect()->action('backOffice.setting.product.index');
    }
    
    /**
    * Restore the specified resource back to storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function restore($id)
    {
        return redirect()->action('backOffice.setting.product.index');
    }
}
