<?php

namespace DurianSoftware\Http\Controllers\BackOffice\Marketing;

use Session;
use Illuminate\Http\Request;
use DurianSoftware\Date;
use DurianSoftware\Http\Controllers\Controller;
use DurianSoftware\Http\Requests\BackOffice\Marketing\BundledProductRequest;
use DurianSoftware\Models\BundledProduct;
use DurianSoftware\Models\BundledItems;
use DurianSoftware\Models\CustomerTier;
use DurianSoftware\Models\BundledCustomerTierPrices;
use Carbon\Carbon;

class BundledProductController extends Controller
{
    public $perPage = 10;

    public function __construct()
    {
        $this->client_id = 1;
        if (session()->has('client_id')) {
            $this->client_id = session()->get('client_id');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            Session::put('search', $search);
            // $model = BundledProduct::select(
            //     'dim_bundled_product.*',
            //     'bundled_items.id'
            // )->withTrashed()->like(['bundled_name', 'promotion_srp', 'remark'], $search);
            $model = BundledProduct::withTrashed()->like(['bundled_name', 'promotion_srp', 'remark'], $search);
        } elseif ($request->filled('excel')) {
            // $search = Session::get('search');
            // $model = BundledProduct::select(
            //     'dim_bundled_product.*',
            //     'bundled_items.id'
            // )->withTrashed()->like(['bundled_name', 'promotion_srp', 'remark'], $search);
            $search = Session::get('search');
            $model = BundledProduct::withTrashed()->like(['bundled_name', 'promotion_srp', 'remark'], $search);
        } else {
            // $model = BundledProduct::select(
            //     'dim_bundled_product.*',
            //     'bundled_items.id'
            // )->withTrashed();
            $model = BundledProduct::withTrashed();
        }

        // $model = $model->join('bundled_items', 'bundled_items.bundled_product_id', '=', 'dim_bundled_product.id')
        //                     ->where('client_id', $this->client_id);
        // $model = $model->where('bundled_items.client_id', $this->client_id)->get();
        $sort  = $request->has('sort') ? $request->sort : 'id';
        $order = $request->has('order') ? $request->order : 'asc';
        $model = $model->orderBy($sort, $order);
     
        if ($request->filled('excel')) {
            $excel = collect([[
                'Bundled Product Name',
                'Promotion SRP',
                'Start date',
                'End date',
                'is_approve',
                'created_at',
                'updated_at',
                'deleted_at'
            ]]);

            $data = $model->select([
                'bundled_name',
                'promotion_srp',
                'start_date_id',
                'end_date_id',
                'is_approve',
                'created_at',
                'updated_at',
                'deleted_at'
            ])->get();

            $excel = $excel->concat($data->toArray());
            return $excel->downloadExcel('Bundled Products.csv');
        }
        $model = $model->paginate($this->perPage);

        return view('backOffice.marketing.bundledProduct.index', [
                        'products' => $model,
                        'sort' => $sort,
                        'order' => $order
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = null;

        if ($request->has('id')) {
            $product = BundledProduct::withTrashed()->company($this->client_id)->find($request->id);
            if (empty($product)) {
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('warning', 'alert.force_delete_before_duplicate');
            }
            if ($product->trashed()) {
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('warning', 'alert.delete_before_duplicate');
            }
            if (!empty($product)) {
                $request->session()->flashInput($product->toArray());
            }
        }

        $bundledItems = BundledItems::where('client_id', $this->client_id)
                                        ->where('bundled_product_id', $request->id)->get();
        $customerTier = CustomerTier::where('client_id', $this->client_id)->get();
        return view('backOffice.marketing.bundledProduct.create', [
            'customertier' => $customerTier,
            'bundledItems' => $bundledItems
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BundledProductRequest $request)
    {
        $data = $request->except('_token');
        // $clientId = Session::get('client_id');
        $clientId = $this->client_id;

        \DB::beginTransaction();
        try {
            $startDate = Date::InsertStrDate(trim($data['start_date_id']));
        } catch (\Exception $e) {
            return back()
                ->with('warning', 'Can\'t Create')
                ->withInput();
        }

        try {
            $endDate = Date::InsertStrDate(trim($data['end_date_id']));
        } catch (\Exception $e) {
            return back()
                ->with('warning', 'Can\'t Create')
                ->withInput();
        }

        try {
            //Duplicate
            if ($request->has('id')) {
                $bundledProduct = BundledProduct::find($request->id)->replicate();
                $bundledProduct->save();
                \DB::commit();
                return redirect()->route('backOffice.marketing.bundled-product.edit', ['products' => $bundledProduct]);
            }

            //Store
            $product = BundledProduct::create([
                'client_id'             => $clientId,
                'bundled_name'          => trim($data['bundled_name']),
                'promotion_srp'         => trim($data['promotion_srp']),
                'start_date_id'         => $startDate->id,
                'end_date_id'           => $endDate->id,
                'remark'                => trim($data['remark']),
            ]);

            $bundledItems = [];
            if (!empty($data['bundledItems'])) {
                foreach ($data['bundledItems'] as $key => $product_item_id) {
                    array_push($bundledItems, [
                        'client_id' => $clientId,
                        'bundled_product_id' => $product->id,
                        'product_item_id' => intval($product_item_id),
                        'quantity' => $data['qty'][$key],
                        'product_id' => intval(9),
                        'product_srp' => $data['srp'][$key],
                        'region_id' => 999,
                        'platfrom_id' => 999,
                        'edition_id' => 999,
                        'category_id' => 999,
                    ]);
                }
            }

            if (count($bundledItems) > 0) {
                try {
                    BundledItems::insert($bundledItems);
                } catch (\Exception $e) {
                    // dd($e->getMessage());
                    return back()
                        ->with('warning', 'Can\'t Create')
                        ->withInput();
                }
            }

            $customerTierItems = [];
            if (!empty($data['customerTierItem'])) {
                foreach ($data['customerTierItem'] as $customer_tier_id => $price) {
                    if (intval($price) > 0) {
                        array_push($customerTierItems, [
                            'client_id' => $clientId,
                            'bundled_product_id' => $product->id,
                            'customer_tier_id' => intval($customer_tier_id),
                            'price' => intval($price),
                        ]);
                    }
                }
            }

            if (count($customerTierItems) > 0) {
                try {
                    BundledCustomerTierPrices::insert($customerTierItems);
                } catch (\Exception $e) {
                    // dd($e->getMessage());
                    return back()
                        ->with('warning', 'Can\'t Create')
                        ->withInput();
                }
            }
        } catch (Exception $e) {
            \DB::rollback();
            //Log Error Message
            new LogThrownError($e);
            //Add custom error message
            $errors = MessageBag::add('products', 'We cannot create a Bundled Product.');
            return view('backOffice.marketing.bundled-product.index')->withErrors($errors);
        }

        \DB::commit();

        return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('success', 'alert.save_success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('backOffice.marketing.bundledProduct.show');
    }

    /**
     * Display the specified resource for printing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        return view('backOffice.marketing.bundledProduct.print');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = BundledProduct::withTrashed()->company($this->client_id)->find($id);
        if (empty($product)) {
            return redirect()->route('backOffice.marketing.bundled-product.index')
                ->with('warning', 'alert.force_delete_before_edit');
        }
        if ($product->trashed()) {
            return redirect()->route('backOffice.marketing.bundled-product.index')
                                ->with('warning', 'alert.delete_before_edit');
        }

        $product['dm_start_date_id'] = $product['start_date_id'];
        $product['dm_end_date_id'] = $product['end_date_id'];
        $product['start_date_id'] = $this->createDateFormat('d/m/Y', $product['start_date_id']);
        $product['end_date_id'] = $this->createDateFormat('d/m/Y', $product['end_date_id']);
        $product['promotion_srp'] = intval($product['promotion_srp']);
        $request->session()->flashInput($product->toArray());
        
        $customerTier = CustomerTier::where('client_id', $this->client_id)->get();
        $bundledCustomerTierPrices = BundledCustomerTierPrices::where('client_id', $this->client_id)
                                                                    ->where('bundled_product_id', $id)->get();
        $bundledItems = BundledItems::where('client_id', $this->client_id)->where('bundled_product_id', $id)->get();
                                           
        $bundledPrices = [];
        if (count($bundledCustomerTierPrices) > 0) {
            foreach ($bundledCustomerTierPrices as $i => $data) {
                $bundledPrices[$data->customer_tier_id] = $data;
            }
        }

        return view('backOffice.marketing.bundledProduct.create', [
                        'id' => $id,
                        'customertier' => $customerTier,
                        'bundledPrices' => $bundledPrices,
                        'bundledItems' => $bundledItems
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BundledProductRequest $request, $id)
    {
        $product = BundledProduct::withTrashed()->company($this->client_id)->find($id);
        if (empty($product)) {
            return redirect()->route('backOffice.marketing.bundled-product.index')
                                ->with('warning', 'alert.force_delete_before_edit');
        }
        if ($product->trashed()) {
            return redirect()->route('backOffice.marketing.bundled-product.index')
                                ->with('warning', 'alert.delete_before_edit');
        }
       
        try {
            $startDate = Date::InsertStrDate(trim($request['start_date_id']));
        } catch (\Exception $e) {
            return back()
                ->with('warning', 'Can\'t Create')
                ->withInput();
        }

        try {
            $endDate = Date::InsertStrDate(trim($request['end_date_id']));
        } catch (\Exception $e) {
            return back()
                ->with('warning', 'Can\'t Create')
                ->withInput();
        }

        $request['promotion_srp'] = str_replace(',', '', $request['promotion_srp']);
        $request['start_date_id'] = $startDate->id;
        $request['end_date_id'] = $endDate->id;
        
        $product->update($request->all());
        $this->updateCustomerTierItem($request->all(), $id);
        $this->updateBundledItems($request->all(), $id);
        
        return redirect()->route('backOffice.marketing.bundled-product.index')->with("success", "alert.update_success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = BundledProduct::withTrashed()->company($this->client_id)->find($id);
        if ($request->has('_force')) {
            if ($model == null) {
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('success', 'alert.force_delete_success');
            } elseif ($model->trashed()) {
                $model->bundledItems()->forceDelete();
                $model->forceDelete();
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('success', 'alert.force_delete_success');
            } else {
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('success', 'alert.delete_success');
            }
        } else {
            if ($model == null) {
                return redirect()->route('backOffice.marketing.bundled-product.index')
                    ->with('warning', 'alert.force_delete_before_edit');
            } elseif (!$model->trashed()) {
                $model->bundledItems()->delete();
                $model->delete();
            }
            return redirect()->route('backOffice.marketing.bundled-product.index')
                                ->with('success', 'alert.delete_success');
        }
    }
    
    /**
    * Restore the specified resource back to storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function restore($id)
    {
        $bundledProduct = BundledProduct::withTrashed()->company($this->client_id)->find($id);
        if ($bundledProduct != null) {
            if ($bundledProduct->trashed()) {
                $bundledProduct->restore();
            }
            return redirect()->route('backOffice.marketing.bundled-product.index')
                                ->with('success', 'alert.restore_success');
        }
        return redirect()->route('backOffice.marketing.bundled-product.index')
                            ->with('warning', 'alert.force_delete_before_edit');
    }
    
    public function removeitem()
    {
        // return view('backOffice.marketing.bundledProduct.index');
    }
    
    public function createDateFormat($format, $dateId)
    {
        $strDate = Date::where('client_id', $this->client_id)->find($dateId);
        $strDateFormat = Carbon::createFromFormat($format, $strDate->date .'/'. $strDate->month .'/'. $strDate->year);
   
        return $strDateFormat->format($format);
    }

    public function updateCustomerTierItem($request, $id)
    {
        if (!empty($request['customerTierItem'])) {
            $customerTierItems = [];
            foreach ($request['customerTierItem'] as $key => $price) {
                if (!is_null($price) && !empty($request['customer_tier_prices_id'][$key])) {
                    $values['price'] = $price;
                    BundledCustomerTierPrices::where('id', $request['customer_tier_prices_id'][$key])->update($values);
                } elseif (!is_null($price)) {
                    if (intval($price) > 0) {
                        array_push($customerTierItems, [
                            'client_id' => $this->client_id,
                            'bundled_product_id' => $id,
                            'customer_tier_id' => intval($key),
                            'price' => intval($price),
                        ]);
                    }
                }
            }

            if (count($customerTierItems) > 0) {
                BundledCustomerTierPrices::insert($customerTierItems);
            }
        }
    }

    public function updateBundledItems($request, $id)
    {
        $bundledItemsInsertNews = [];
        if (count($request['bundledItems']) > 0) {
            foreach ($request['bundledItems'] as $key => $value) {
                if (!empty($value)) {
                    $data = array(
                        'client_id' => $this->client_id,
                        'bundled_product_id' => $id,
                        'product_item_id' => intval(777),
                        'quantity' => $request['qty'][$key],
                        'product_id' => intval(9),
                        'product_srp' => $request['srp'][$key],
                        'region_id' => 999,
                        'platfrom_id' => 999,
                        'edition_id' => 999,
                        'category_id' => 999,
                    );
                    BundledItems::where('id', $value)->update($data);
                } else {
                    array_push($bundledItemsInsertNews, [
                        'client_id' => $this->client_id,
                        'bundled_product_id' => $id,
                        'product_item_id' => intval(777),
                        'quantity' => $request['qty'][$key],
                        'product_id' => intval(9),
                        'product_srp' => $request['srp'][$key],
                        'region_id' => 999,
                        'platfrom_id' => 999,
                        'edition_id' => 999,
                        'category_id' => 999,
                    ]);
                }
            }

            if (count($bundledItemsInsertNews) > 0) {
                BundledItems::insert($bundledItemsInsertNews);
            }
        }

        // BundledItems::updateOrCreate(
        //     ['id' => '25'],
        //     $bundledItemsUpdateColumes
        // );
    }

    private function checkDeleteWithMsg($data, $msg)
    {
        if (empty($data)) {
             \Session::flash('warning', $msg);
            \App::abort(302, '', ['Location' => route('backOffice.news-and-event.index')]);
        }
    }
}
