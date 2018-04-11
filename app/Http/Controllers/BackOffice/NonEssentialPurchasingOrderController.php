<?php

namespace DurianSoftware\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use DurianSoftware\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

use DurianSoftware\Http\Requests\CategoryFormRequest;
use Illuminate\Routing\Redirector;
use DurianSoftware\Models\NonEssentialPurchasingOrder;
use DurianSoftware\Models\Warehouse;

use Response;
use Validator;
use Session;
use Lang;
use Excel;

class NonEssentialPurchasingOrderController extends Controller
{
    
    public $perPage = 15;
    
    public $path = 'non-essential-purchasing-order';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->company_id = 1;
        if (session()->has('company_id')) {
            $this->company_id = session()->get('company_id');
        }
        $this->NonEssentialPurchasingOrder = NonEssentialPurchasingOrder::where('client_id', $this->company_id);
        $this->ApprovedNonEssentialPurchasingOrders = NonEssentialPurchasingOrder::where('client_id', $this->company_id)->where('is_approve', 'approve');
        $this->PendingNonEssentialPurchasingOrders = NonEssentialPurchasingOrder::where('client_id', $this->company_id)->where('is_approve', 'NULL');
    }

    public function index(Request $request)
    {

        $OrderBy = 'desc';
        $Order = 'id';

        $NonEssentialPurchasingOrders = $this->NonEssentialPurchasingOrder->select();
        $ApprovedNonEssentialPurchasingOrders = $this->ApprovedNonEssentialPurchasingOrders->select();
        $PendingNonEssentialPurchasingOrders = $this->PendingNonEssentialPurchasingOrders->select();
        if ($request->has('search')) {
            $search = $request->input('search');
            $PendingNonEssentialPurchasingOrders = $NonEssentialPurchasingOrders
                            ->where(function ($query) use ($search) {
                                $query->orWhere('remark', 'LIKE', '%' . $search . '%');
                                $query->orWhere('billing_address', 'LIKE', '%' . $search . '%');
                                $query->orWhere('amount', 'LIKE', '%' . $search . '%');
                                $query->orWhere('discount', 'LIKE', '%' . $search . '%');
                                $query->orWhere('amount_before_vat', 'LIKE', '%' . $search . '%');
                                $query->orWhere('vat', 'LIKE', '%' . $search . '%');
                                $query->orWhere('grand_total', 'LIKE', '%' . $search . '%');
                            })                            ;
            $ApprovedNonEssentialPurchasingOrders = $NonEssentialPurchasingOrders
                            ->where(function ($query) use ($search) {
                                $query->orWhere('remark', 'LIKE', '%' . $search . '%');
                                $query->orWhere('billing_address', 'LIKE', '%' . $search . '%');
                                $query->orWhere('amount', 'LIKE', '%' . $search . '%');
                                $query->orWhere('discount', 'LIKE', '%' . $search . '%');
                                $query->orWhere('amount_before_vat', 'LIKE', '%' . $search . '%');
                                $query->orWhere('vat', 'LIKE', '%' . $search . '%');
                                $query->orWhere('grand_total', 'LIKE', '%' . $search . '%');
                            })                            ;
        } else {
            $ApprovedNonEssentialPurchasingOrders = $ApprovedNonEssentialPurchasingOrders
                            ->withTrashed()
                            ->orderBy($Order, $OrderBy)
                            ->paginate($this->perPage);
            $PendingNonEssentialPurchasingOrders = $PendingNonEssentialPurchasingOrders
                            ->withTrashed()
                            ->orderBy($Order, $OrderBy)
                            ->paginate($this->perPage);

            $NonEssentialPurchasingOrders = $NonEssentialPurchasingOrders
                            ->withTrashed()
                            ->orderBy($Order, $OrderBy)
                            ->paginate($this->perPage);
        }
        //                 echo "|||||||||||||||||||||||||||||<pre>";
        // var_dump($PendingNonEssentialPurchasingOrders);
        // die();
        return view('backOffice.nonEssentialPurchasingOrder.index', compact('NonEssentialPurchasingOrders', 'PendingNonEssentialPurchasingOrders', 'ApprovedNonEssentialPurchasingOrders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Warehouses = Warehouse::withTrashed()->paginate(100);
        ;
        $action = route('backOffice.purchasing.non-essential-purchasing-order.store') ;
        // echo "<pre>";
        // var_dump($Warehouses);
        // die();
        return view('backOffice.nonEssentialPurchasingOrder.create', compact('Warehouses', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "<pre>";

        $date = date('Y-m-d H:i:s');
        ;
        $data = $request->all();
        $total_quantity = 0;
        $amount = 0;
        $total_dc = 0;
        foreach ($data['qty'] as $key => $value) {
            $total_quantity += $value;
            $amount += $value * ($data['price'][$key] - $data['dc'][$key]);
            $total_dc += $data['dc'][$key];
        }
        $amount_before_vat = $amount - $data['discount'];
        $vat = $amount_before_vat * $data['vat'] / 100 ;
        $grand_total = $amount_before_vat + $vat;


        $data = $request->all();



        $data['client_id'] = $this->company_id;
        $data['company_id'] = 1;
        $data['branch_id'] = 1;
        $data['billing_address'] = "address ";
        $data['sub_district_id'] = 1;
        $data['district_id'] = 1;
        $data['province_id'] = 1;
        $data['postcode_id'] = 1;
        $data['payment_conditions_credit_term_id'] = 1;
        $data['document_date_id'] = 1;
        // $data['document_date_id'] = $date;
        $data['due_date_id'] = 2;
        // $data['due_date_id'] = $request->input('due_date');


        $data['total_quantity'] = $total_quantity;
        $data['backlog_quatity'] = 0;
        $data['currency_id'] = 1;
        $data['amount'] = $amount;

        $data['amount_before_vat'] = $amount_before_vat;
        $data['vat'] = $vat;
        $data['grand_total'] = $grand_total;
        $data['approval_user_id'] = 1;
        $data['is_approve'] = 'NULL';
        $data['shipping_date_id']=0;
        // $data['remark'] = 1;


        $NonEssentialPurchasingOrder_created = NonEssentialPurchasingOrder::create($data);
        foreach ($data['product_id'] as $key => $value) {
            $quantity = $data['qty'][$key] ;
            $amount = ($data['price'][$key] - $data['dc'][$key]);
            $dc = $data['dc'][$key];
            $sub_total_before_vat = $amount * $quantity;
            $fact_data = [
                            'client_id' => $data['client_id'],
                            // 'purchasing_order_id' =>  ,
                            'product_id' => $value ,
                            'publisher_id' => 1 ,
                            'category_id' => 1 ,
                            'platform_id' => 1 ,
                            'edition_id' => 1 ,
                            'region_id' => 1  ,
                            'product_item_id' => $key ,
                            'unit_id' => 1 ,
                            'product_item_barcodes_id' => 1 ,
                            'warehouse_id' => 1 ,
                            'quantity' => $data['qty'][$key] ,
                            'currency_id' => 1 ,
                            'price_per_unit' => $data['price'][$key],
                            'discount_per_unit' => $data['dc'][$key] ,
                            'amount_before_vat_per_unit' => $amount,
                            'vat_per_unit' => ($amount * $data['vat']) / 100 ,
                            'amount_including_vat_per_unit' => $amount + ($amount * $data['vat'] / 100 ),
                            'sub_total_before_vat' => $sub_total_before_vat,
                            'vat_sub_total' => ($sub_total_before_vat * $data['vat']) / 100,
                            'sub_total_including_vat'=> $sub_total_before_vat + ($sub_total_before_vat * $data['vat'] / 100)

                        ];
            $FactNonEssentialPurchasingOrders_created = $NonEssentialPurchasingOrder_created->FactNonEssentialPurchasingOrders()->create($fact_data);

            var_dump($FactNonEssentialPurchasingOrders_created);
        }
        die();




        return redirect()->route('backOffice.purchasing.non-essential-purchasing-order.index')->with('success', 'Create success');
        // return redirect()->route('backOffice.non-essential-purchasing-order.index');
    }

    public function duplicate($id)
    {

        $Warehouses = Warehouse::withTrashed()->paginate(100);
        ;
        $NonEssentialPurchasingOrders = NonEssentialPurchasingOrder::find($id);
        $this->checkDeleteWithMsg($NonEssentialPurchasingOrders, "Data not found");
        $action = route('backOffice.purchasing.non-essential-purchasing-order.store-duplicate') ;
        return view('backOffice.nonEssentialPurchasingOrder.create', compact('action', 'Warehouses'))->with('NonEssentialPurchasingOrders', $NonEssentialPurchasingOrders);
    }
    public function patchStatus(Request $request ,$id)
    {


        try {
            $model = NonEssentialPurchasingOrder::where('id', $id)
                ->update([
                    'is_approve' => $request->input('is_approve')
                ]);
            
            echo 2;
        } catch (\Illuminate\Database\QueryException $e) {
            echo 0;
        }
        die();
    }

    private function checkDeleteWithMsg($data, $msg)
    {
        if (empty($data)) {
             \Session::flash('warning', $msg);
            \App::abort(302, '', ['Location' => route('backOffice.nonEssentialPurchasingOrder.index')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $NonEssentialPurchasingOrders = NonEssentialPurchasingOrder::find($id);
        return view('backOffice.nonEssentialPurchasingOrder.show',compact('NonEssentialPurchasingOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backOffice.nonEssentialPurchasingOrder.update');
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
        return redirect()->action('backOffice.nonEssentialPurchasingOrder.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nonessentialpurchasingorders = NonEssentialPurchasingOrder::withTrashed()->find($id);
        $this->checkDelete($nonessentialpurchasingorders);
        if ($nonessentialpurchasingorders->trashed()) {
            $nonessentialpurchasingorders->forceDelete();
            return redirect()->route('backOffice.news-and-event.index')
            ->with('success', 'Force Delete success');
        }
        $nonessentialpurchasingorders->delete();
        return redirect()->route('backOffice.purchasing.non-essential-purchasing-order.index');
    }

    private function checkDelete($model)
    {
       
        if ($model == null) {
            \Session::flash('warning', 'Tag was deleted');
            \App::abort(302, '', ['Location' => route('backOffice.purchasing.non-essential-purchasing-order.index')]);
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
        return redirect()->action('backOffice.nonEssentialPurchasingOrder.index');
    }
}
