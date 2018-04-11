@extends('layouts.backOffice.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/non-essential-purchasing-order/create.css')}}"/>
@endsection

@section('module_name', 'PURCHASING ORDER (NON ESSENTIAL ITEMS)')
@section('page_name', 'CREATE')

@section('body')
<div class="x_content scroll-2">
<section>
    <form action="{{route("backOffice.purchasing.non-essential-purchasing-order.store")}}" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="spaceContent">
          <div class="first-row">
              <div class="row">
                  <div class="col-md-6">
                    <div class="date-time">
                        <h4 class="text-black">PO #1</h4>
                        <div class="input-group date" id="datepicker" >
                            <input type="text" class="form-control" name="document_date_id" value="{{(isset($NonEssentialPurchasingOrders)) ? $NonEssentialPurchasingOrders->document_date_id : old('document_date_id') }}"/>
                            <span class="input-group-addon">
                                <i class="fa fa-calendar" ></i>
                            </span>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>

        <div class="w800">
            <div class="row">
                <div class="col-xs-9">
                    <div class="label">SUPPLIER:</div>
                    <div class="sup-content">
                        <div class="sup-image">
                            <img src="{{ asset('images/backOffice/purchasingOrder/adiwit_logo.jpg') }}" class="img-responsive">
                        </div>
                        <div class="sup-detail">
                            <input type="text" class="form-control">
                            <div><strong>18 Kijpanit Bld. Patpong Rd., Suriyawong, Bangrak, Bangkok THA 10500</strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <label for="">DUE DATE</label>
                    <div class="input-group date" id="datepicker" >
                        <input type="text" class="form-control" name="due_date" value="{{(isset($NonEssentialPurchasingOrders)) ? $NonEssentialPurchasingOrders->due_date_id : old('due_date') }}"/>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" ></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3">
                    <div class="col-form-group">
                        <label for="">PAYMENT CONDITION</label>
                        <select id="basic" name="payment_conditions_credit_term_id" class="form-control">
                            <option value="1">30 DAY CREDIT</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-group">
                        <label for="">CURRENCY</label>
                        <select id="basic" name="currency_id" class="form-control">
                            <option value="1">USD</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4">
                    <label for="">SHIPPING DATE</label>
                    <div class="input-group date shipping_date" id="datepicker" >
                        <input type="text" class="form-control" name="shipping_date_id" value="{{(isset($NonEssentialPurchasingOrders)) ? $NonEssentialPurchasingOrders->shipping_date_id : old('shipping_date') }}"/>
                        <span class="input-group-addon">
                            <i class="fa fa-calendar" ></i>
                        </span>
                    </div>
                </div>
                <div class="col-xs-3">
                    <label for="">ORDER LIMIT</label>
                    <div class="limit_amount">0.00 USD</div>
                </div>
            </div>
        </div>

        <div class="spaceContent">
            <div id="itemList">
                <table class="table table-headfix">
                    <thead>
                        <tr class="header">
                            <th class="align-left w-500">ITEM NAME</th>
                            <th class="text-center w-130">WAREHOUSE</th>
                            <th class="text-center w-130">QTY</th>
                            <th class="text-center w-130">PRICE / UNIT<br/><span class="text-light">(BEFORE VAT)</span></th>
                            <th class="text-center w-130">DISCOUNT<br/><span class="text-light">(PER UNIT)</span></th>
                            <th class="text-center w-100">SUB TOTAL</th>
                            <th class="w-50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0;$i<4;$i++)
                        <tr>
                            <td class="w-500">
                                <div class="col-sm-1">
                                    <a href="" class="text-danger"><i class="fa fa-trash"></i></a>
                                </div>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" placeholder="PRODUCT" id="product{{ $i }}" name="product[]" value="Product {{ $i }}" data-action="typeaheadProduct">
                                    <input type="hidden" id="product_id{{ $i }}" name="product_id[]" value="{{(isset($NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i])) ? $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i]->product_id : old('product_id.'. $i) }}" >
                                </div>
                            </td>
                            <td class="w-130">
                                <select class="form-control">
                                    @foreach($Warehouses as $Warehouse)
                                    <option value="">{{ $Warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </td> 
                            <td class="w-130"><input type="text" class="form-control" name="qty[]" id="qty{{ $i }}" value="{{ ( isset( $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i] ) ) ? $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i]->quantity : old('qty.'. $i) }}" onchange="caltotal('{{ $i }}')"></td>
                            <td class="w-130"><input type="text" class="form-control" name="price[]" id="price{{ $i }}" value="{{ ( isset( $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i] ) ) ? number_format($NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i]->price_per_unit,2) : old('price.'. $i) }}" onchange="caltotal('{{ $i }}')"></td>
                            <td class="w-130"><input type="text" class="form-control" name="dc[]" id="dc{{ $i }}" value="{{ ( isset( $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i] ) ) ? number_format($NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i]->discount_per_unit,2) : old('dc.'. $i) }}" onchange="caltotal('{{ $i }}')"></td>
                            <td class="w-100 text-center" id="sub_total{{ $i }}">{{ ( isset( $NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i] ) ) ? number_format($NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders[$i]->sub_total_before_vat,2) : '0.00' }}</td>
                            <td class="w-50 text-right">USD</td>
                        </tr>
                        @endfor

                        <tr>
                            <td class="w-500">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" placeholder="PRODUCT" data-action="typeaheadProduct" onchange ="console.log(22)" >
                                </div>
                            </td>
                            <td class="w-130">
                                <select class="form-control">
                                    <option value="">a</option>
                                    <option value="">b</option>
                                    <option value="">c</option>
                                </select>
                            </td>
                            <td class="w-130"><input type="text" class="form-control"></td>
                            <td class="w-130"><input type="text" class="form-control"></td>
                            <td class="w-130"><input type="text" class="form-control"></td>
                            <td class="w-100 text-center"></td>
                            <td class="w-50 text-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="summary">
            <table class="table">
                <tr>
                    <td class="col-md-6">
                        <div class="form-group">
                            <label for="">REMARK</label>
                            <textarea class="form-control" name="remark"> </textarea>
                        </div>
                    </td>
                    <td align="right" class="col-md-6">
                        <table id="summary" align="right">
                            <tr>
                                <td colspan="2" align="right"><strong class="text-black">Total</strong></td>
                                <td align="right" class="onlyText" id="summary_total">{{ ( isset( $NonEssentialPurchasingOrders ) ) ? number_format($NonEssentialPurchasingOrders->amount,2) : '0.00' }}</td>
                                <td><strong class="text-black">USD</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><strong class="text-black">Discount</strong></td>
                                <td align="right"><input type="text" class="form-control"  name="discount" id="discount" value="{{ ( isset( $NonEssentialPurchasingOrders ) ) ? number_format($NonEssentialPurchasingOrders->discount,2) : '0.00' }}" style="text-align: right" onchange="summary()"></td>
                                <td><strong class="text-black">USD</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4"><hr style="border-color: #ddd;" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><strong class="text-black">Total Before VAT</strong></td>
                                <td align="right" class="onlyText"  id="summary_total_bf_vat">{{ ( isset( $NonEssentialPurchasingOrders ) ) ? number_format($NonEssentialPurchasingOrders->amount_before_vat,2) : '0.00' }}</td>
                                <td><strong class="text-black">USD</strong></td>
                            </tr>
                            <tr>
                                <td align="right"><strong class="text-black vat">VAT</strong></td>
                                <td class="text-black" style="width: 70px; padding-left: 0;">
                                    <select name="vat" id="vat" class="form-control">
                                        <option value="7" selected>7%</option>
                                    </select>
                                </td>
                                <td align="right" class="onlyText"  id="summary_vat">{{ ( isset( $NonEssentialPurchasingOrders ) ) ? number_format( $NonEssentialPurchasingOrders->vat,2) : '0.00' }}</td>
                                <td><strong class="text-black">USD</strong></td>
                            </tr>
                            <tr class="text-black">
                                <td colspan="2" align="right"><strong id='total'>NET Total</strong></td>
                                <td align="right" class="onlyText"><span id="total">{{ ( isset( $NonEssentialPurchasingOrders ) ) ? number_format($NonEssentialPurchasingOrders->grand_total,2) : '0.00' }}</span></td>
                                <td><strong>USD</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="spaceContent">
            <div class="button-actions" align="center">
                <button type="button" class="btn btn-ngin btn-default"><span class="btn-label"><i class="fa fa-print primary" aria-hidden="true"></i> </span>PRINT</button>
                <button type="submit" class="btn btn-ngin btn-default"><span class="btn-label"><i class="fa fa-floppy-o success" aria-hidden="true"></i> </span>SAVE</button>
                <button type="button" class="btn btn-ngin btn-default"><span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i> </span>CANCEL</button>
            </div>
        </div>
    </form>
</section>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/back-office/non-essential-purchasing-order/create.js') }}"></script>
    <script type="text/javascript">


        $('#product' + 0).bind('typeahead:select typeahead:autocomplete', function(e, v) {
            console.log('conge',v,e);
            setdata(0,v)
        });
        $('#product' + 1).bind('typeahead:select typeahead:autocomplete', function(e, v) {
            console.log('conge',v,e);
            setdata(1,v)
        });
        $('#product' + 2).bind('typeahead:select typeahead:autocomplete', function(e, v) {
            console.log('conge',v,e);
            setdata(2,v)
        });
        $('#product' + 3).bind('typeahead:select typeahead:autocomplete', function(e, v) {
            console.log('conge',v,e);
            setdata(3,v)
        });

        function setdata(i,v){          
            $('#product_id' + i).val(v.barcode);
            // $('input[name="product"]').val(v.code)
            // $('input[name="province_name"]').val(v.province_name)
            // $('input[name="district_name"]').val(v.district_name)
            // $('input[name="sub_district_name"]').val(v.sub_district_name)
            // $('#product').typeahead('val', '');
            // $('#test-d').addClass('hidden')
            // return false
            
            
            // console.log(e,v)
            $('#qty' + i).val(1);
            // $('#price' + i).val(v.price);
            $('#dc' + i).val(0);
            caltotal(i);
        }

        function caltotal(i){
            var qty = $('#qty' + i);
            var price = $('#price' + i);
            var dc  = $('#dc' + i);
            $('#sub_total' + i).html( parseFloat((price[0].value - dc[0].value)* qty[0].value).toFixed(2) + '');
            summary();
        }
        function summary(){
            var sumtotal = 0;
            for (var i = 0; i <4; i++) {
                    
                var total = $('#sub_total' + i);
                if (total) {
                    sumtotal += parseFloat(total.html());
                }
                
            }
            totaldc = $('#discount');
            vat = $('#vat');
            summary_total_bf_vat = parseFloat(sumtotal) - parseFloat(totaldc[0].value);
            summary_vat = summary_total_bf_vat * parseFloat(vat[0].value) / 100;


                    console.log(vat[0].value);


            sptotal = document.querySelectorAll("span#total");
            $('#summary_total').html( parseFloat(sumtotal).toFixed(2));
            $('#summary_total_bf_vat').html( parseFloat(summary_total_bf_vat).toFixed(2));
            $('#summary_vat').html( parseFloat(summary_vat).toFixed(2));
            
            sptotal[0].textContent = parseFloat(summary_total_bf_vat + summary_vat).toFixed(2);
        }
    </script>

@endsection

