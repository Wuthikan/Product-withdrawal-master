<?php

namespace DurianSoftware\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use DurianSoftware\Http\Controllers\Controller;

use DurianSoftware\Models\PurchasingOrder;
use DurianSoftware\Models\ProductType;
use DurianSoftware\Models\Warehouse;
use DurianSoftware\Models\Currency;
use DurianSoftware\Models\CreditTerm;

use DB;

class PurchasingOrderController extends Controller
{
    private $client_id = 1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchasing_orders = PurchasingOrder::with([
                'company',
                'branch',
                'inquiryPurchasingOrders',
                'documentDate',
                'shippingDate'])
            ->withTrashed();

        // if ($request->has('search') && $request->get('search') == '') {
        //     return redirect()->route('backOffice.purchasing-order.index');
        // } else {
        //     $data_search = $request->get('search');
        //     $purchasing_orders = $purchasing_orders
        //         ->where('', 'LIKE', "%{$data_search}%")
        //         ->orWhere('', 'LIKE', "%{$data_search}%");
        // }

        if ($request->has('approve') && $request->get('approve') == 'pending') {
            $purchasing_orders = $purchasing_orders->where('is_approve', null);
        } elseif ($request->has('approve') && $request->get('approve') == 'approve') {
            $purchasing_orders = $purchasing_orders->where('is_approve', 1);
        } elseif ($request->has('approve') && $request->get('approve') == 'complete') {
            $purchasing_orders = $purchasing_orders->where('is_approve', 0)
                ->orWhere('is_approve', 1);
                //  มีการรับสินค้าครบแล้ว
        } elseif (!$request->has('approve') || ($request->has('approve') && $request->get('approve') == 'partial')) {
            $purchasing_orders = $purchasing_orders->where('is_approve', 1);
            // มีการรับสินค้าบางส่วน
        }

        if ($request->has('rdoOrder')) {
            $sortOrder = $request->get('rdoOrder');
        } else {
            $sortOrder = 'asc';
        }

        if ($request->has('rdoBy') && $request->get('rdoBy') == 'company') {
            $purchasing_orders = $purchasing_orders
                ->leftJoin('dim_companies', 'dim_purchasing_orders.company_id', '=', 'dim_companies.id')
                ->withTrashed()
                ->orderBy('name', $sortOrder);
        } elseif ($request->has('rdoBy') && $request->get('rdoBy') == 'documentDate') {
            $purchasing_orders = $purchasing_orders
                ->leftJoin('dim_dates', 'dim_purchasing_orders.document_date_id', '=', 'dim_dates.id')
                ->withTrashed()
                ->orderBy(DB::raw("CONCAT(year,'-',month,'-',date)"), $sortOrder);
        } elseif ($request->has('rdoBy') && $request->get('rdoBy') == 'shippingDate') {
            $purchasing_orders = $purchasing_orders
                ->leftJoin('dim_dates', 'dim_purchasing_orders.shipping_date_id', '=', 'dim_dates.id')
                ->withTrashed()
                ->orderBy(DB::raw("CONCAT(year,'-',month,'-',date)"), $sortOrder);
        } elseif ($request->has('rdoBy') && $request->get('rdoBy') == 'totalQuantity') {
            $purchasing_orders = $purchasing_orders->orderBy('total_quantity', $sortOrder);
        } elseif ($request->has('rdoBy') && $request->get('rdoBy') == 'backlogQuantity') {
            $purchasing_orders = $purchasing_orders->orderBy('backlog_quantity', $sortOrder);
        } elseif (!$request->has('rdoBy') || ($request->has('rdoBy') && $request->get('rdoBy') == 'id')) {
            $purchasing_orders = $purchasing_orders->orderBy('id', $sortOrder);
        }

        $purchasing_orders = $purchasing_orders->paginate(15, ['dim_purchasing_orders.*']);
        $purchasing_orders->approve = ($request->has('approve')) ? $request->get('approve') : null;

        // return $purchasing_orders;

        return view('backOffice.purchasingOrder.index')->with(compact('purchasing_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_types = ProductType::where('client_id', $this->client_id)->get();
        $warehouses = Warehouse::where('client_id', $this->client_id)->get();
        $credit_terms = CreditTerm::where('client_id', $this->client_id)->get();
        $currencies = Currency::where('client_id', $this->client_id)->get();

        return view('backOffice.purchasingOrder.create')->with(
            compact(
                'product_types',
                'warehouses',
                'credit_terms',
                'currencies'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForInquiry()
    {
        return view('backOffice.purchasingOrder.createForInquiry');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->action('backOffice.purchasingOrder.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchasing_order = PurchasingOrder::with([
                'company',
                'branch',
                'inquiryPurchasingOrders',
                'currency',
                'documentDate',
                'shippingDate'])
            ->withTrashed()
            ->find($id);

        return view('backOffice.purchasingOrder.show')->with(compact('purchasing_order'));
    }

    /**
     * Display the specified resource for printing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        return view('backOffice.purchasingOrder.print');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backOffice.purchasingOrder.update');
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
        $purchasing_order = PurchasingOrder::find($id);
        $this->checkDeleteWithMsg($purchasing_order, "Can't Edit Data");

        $purchasing_order_data = $request->except(['_token', '_method', '_image']);

        if ($purchasing_order_data['is_approve'] && $purchasing_order_data['is_approve'] == "null") {
            $purchasing_order_data['is_approve'] = null;
        }

        $purchasing_order->update($purchasing_order_data);

        return redirect()->route('backOffice.purchasing-order.index')->with('success', 'Update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchasingOrder = PurchasingOrder::withTrashed()->find($id);

        if (!$purchasingOrder->trashed()) {
            $purchasingOrder->delete();
        } else {
            $purchasingOrder->forceDelete();
        }

        return redirect()->route('backOffice.purchasing-order.index');
    }

    public function destroyMany(Request $request)
    {
        try {
            PurchasingOrder::whereIn("id", explode(",", $request->input('deleteAllChecked')))->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('backOffice.purchasing-order.index');
    }

    /**
    * Restore the specified resource back to storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function restore($id)
    {
        $newsevent = PurchasingOrder::withTrashed()->find($id);
        $newsevent->restore();

        return redirect()->route('backOffice.purchasing-order.index');
    }

    private function checkDeleteWithMsg($data, $msg)
    {
        if (empty($data)) {
             \Session::flash('warning', $msg);
            \App::abort(302, '', ['Location' => route('backOffice.news-and-event.index')]);
        }
    }
}
