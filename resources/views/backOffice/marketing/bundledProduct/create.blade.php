{{--
    @author: Kritsada Wongnunta
    @phone: 0835155415
    @email: kritsada.wongnunta@gmail.com
--}}

@extends('layouts.backOffice.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/marketing/bundled-product/create.css')}}"/>
@endsection

@section('module_name', 'BUNDLED PRODUCT')
@section('page_name', 'CREATE')

@section('body')
<div class="x_content scroll-2">
    @include('components/alert', ['errors' => $errors, 'isAlert' => true])
    <form method="post" action="{{empty($id) ? route('backOffice.marketing.bundled-product.store') : route('backOffice.marketing.bundled-product.update', $id)}}"> 
        <div class="form-container">
            {!! csrf_field() !!}
            @if(!empty($id)) {{method_field('put')}} @endif
            <div class="container">
                <div class="row box">
                    <div class="leftBox">
                        <div class="form-group">
                            <label class="control-label" for="">BUNDED PRODUCT NAME</label>
                            <input class="form-control" type="text" name="bundled_name" value="{{request()->input('bundled_name', old('bundled_name'))}}">
                        </div>

                    </div>
                    <div class="rightBox">
                        <div class="form-group">
                            <label class="control-label" for="">PROMOTION SRP</label>
                            <input class="form-control" type="number" name="promotion_srp" value="{{request()->input('promotion_srp', old('promotion_srp'))}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="">REMARK</label>
                            <textarea class="form-control" name="remark" rows="8" cols="80">{{request()->input('remark', old('remark'))}}</textarea>
                        </div>
                    </div>
                    <div class="leftBox">
                        <div class="form-group">
                            <label for="">START</label>
                            <div class="input-group date" id="startDate">
                                <input type="text" class="form-control" id="start_date_id" name="start_date_id"  value="{{request()->input('start_date_id', old('start_date_id'))}}"/>
                                
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="dm_start_date_id" name="dm_start_date_id"  value="{{request()->input('dm_start_date_id', old('dm_start_date_id'))}}"/>
                        </div>
                    </div>
                    <div class="centerBox">
                        TO
                    </div>
                    <div class="rightBox">
                        <div class="form-group">
                            <label for="">END</label>
                            <div class="input-group date" id="endDate">
                                <input type="text" class="form-control" id="end_date_id" name="end_date_id"  value="{{request()->input('end_date_id', old('end_date_id'))}}"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="dm_end_date_id" name="dm_end_date_id"  value="{{request()->input('dm_end_date_id', old('dm_end_date_id'))}}"/>
                        </div>
                    </div>
                </div>
                @if(count($customertier) > 0)
                <div class="row box" style="background-color:#00000017;">
                    @foreach($customertier as $i => $data)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">DEALER PRICE : </label>
                            <label for="">({{$data->name}})</label>
                            <input type="number" name="customerTierItem[{{$data->id}}]" class="form-control" value="{{ isset($bundledPrices[$data->id])? $bundledPrices[$data->id]->price :' ' }}">
                            <input type="hidden" name="customer_tier_prices_id[{{$data->id}}]" class="form-control" value="{{ isset($bundledPrices[$data->id])? $bundledPrices[$data->id]->id :' ' }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <div style="margin-top:20px;">
                    <span style="margin-left:20px;">Barcode / Product Code / Item Name</span>
                    <hr style="margin-top:5px;border-top: 2px solid #0000001f" />
                </div>
                <div class="form-group form-fixed-width">
                    <div class="icon-addon addon-sm">
                        <input type="text" data-action="typeaheadProductBundled" placeholder="SEARCH" class="form-control search" id="SEARCH">
                        <label for="search" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>
                    </div>
                </div>
                <div id="product-items">
                @if(count($bundledItems) > 0)    
                @foreach($bundledItems as $i => $item)
                <div class="card">
                    <div class="row">
                        <div class="col-sm-1 removeContent">
                            <a>
                                <i class="glyphicon glyphicon-trash icon"></i>
                            </a>
                        </div>
                        <div class="col-sm-2 cover">
                            <h1>PSAC-0000{{ $i }}</h1>
                            <img class="img-responsive" src="https://images-na.ssl-images-amazon.com/images/I/817REtxSilL._SX342_.jpg">
                        </div>
                        <div class="col-sm-9 contentDetail">
                            <div class="row">
                                <div class="code">PS4-G</div>
                                <h1 class="productName">CALL OF DUTY</h1>
                                <div class="col-sm-6 detail">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            ITEM TYPE
                                        </div>
                                        <div class="col-sm-8">
                                            : <span class="text-blue">SONY-SW</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            SRP
                                        </div>
                                        <div class="col-sm-8">
                                            : <span class="text-blue">
                                                {{$item->product_srp}}
                                                <input type="hidden" name="srp[{{$i}}]" class="" value="{{$item->product_srp}}">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            REION
                                        </div>
                                        <div class="col-sm-8">
                                            : <span class="text-blue">R3</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            BARCODE
                                        </div>
                                        <div class="col-sm-8">
                                            <div>: <span class="text-blue">8-8888-88888-88-8</span></div>
                                            <div>: <span class="text-blue">9-9999-99999-99-9</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 detail">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <strong>QTY</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number" name="qty[{{$i}}]" value="{{$item->quantity}}" style="width: 50px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            EDITION
                                        </div>
                                        <div class="col-sm-8">
                                            : <strong class="text-blue">STANDARD</strong>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            ZONE
                                        </div>
                                        <div class="col-sm-8">
                                            <div>: 2 <span class="text-blue">(EN)</span></div>
                                            <div>: <span class="text-blue">8-8888-88888-88-8</span></div>
                                            <div>: <span class="text-blue">9-9999-99999-99-9</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tag row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <label class="trigger">
                                Cull of duty
                                <i class="close fa fa-times close-tag"></i>
                            </label>
                            <label class="trigger">
                                Final Fantasy
                                <i class="close fa fa-times close-tag"></i>
                            </label>

                            <input type="hidden" name="bundledItems[{{$i}}]" class="" value="{{$item->id}}">
                            
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                </div>

            </div>
            <hr style="margin-bottom:0;border-top: 3px solid #0000001f;" />
            <div class="titelItem">
                <strong class="pull-left">Total Product</strong>
                <div class="pull-right" id="TotalPleces">{{count($bundledItems)}}  <strong>Pleces</strong></div>
            </div>

        </div> <!-- .form-container -->

        <hr style="margin-bottom:0;border-top: 3px solid #0000001f;" />
        <div align="center" style="margin: 40px 0;">
            <button type="submit" class="btn btn-ngin btn-default m-r-1">
                <span class="btn-label"><i class="fa fa-floppy-o success" aria-hidden="true"></i></span>SAVE
            </button>
            <a type="button" class="btn btn-ngin btn-default" href="{{route('backOffice.marketing.bundled-product.index')}}">
                <span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i></span>CANCEL
            </a>
        </div>
    </form>

</div>
@endsection

@section('script')
    <script src="{{ asset('js/back-office/marketing/bundled-product/create.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        //Set Label Header Page
        $('#lbHeaderPage').html("<h3>BUNDLED PRODUCTS | <span>CREATE</span></h3>");

        $('[data-action="typeaheadProductBundled"]').typeahead(null, {
            name: 'product-search',
            hint: true,
            display: 'name',
            limit: 7,
            highlight: true,
            source: productSearch.ttAdapter(),
            templates: {
                notFound: '<div class="product-search-item"><h4 class="product-search-title">not found</h4></div>',
                suggestion: productTemplate
            }
        });

        $('[data-action="typeaheadProductBundled"]').on('typeahead:selected', function(evt, item) {
   
            // console.log('Selection: ' + JSON.stringify(item));
            var barcodeItemArr = [];
            $.each(item.barcode, function(key, val) {
                barcodeItemArr.push('<div>: <span class="text-blue">' + val + '</span></div>');
            });

            var barcodeItem = barcodeItemArr.toString().replace(/,/g, '');

            var appendItem = '<div class="card">' +
                    '<div class="row">' +
                        '<div class="col-sm-1 removeContent">' +
                            '<a>' +
                                '<i class="glyphicon glyphicon-trash icon"></i>' +
                            '</a>' +
                        '</div>' +
                        '<div class="col-sm-2 cover">' +
                            '<h1>' + item.external_code + '</h1>' +
                            '<img class="img-responsive" src="'+ item.image + '">' +
                        '</div>' +
                        '<div class="col-sm-9 contentDetail">' +
                            '<div class="row">' +
                                '<div class="code">'+ item.platform + '</div>' +
                                '<h1 class="productName">CALL OF DUTY</h1>' +
                                '<div class="col-sm-6 detail">' +
                                    '<div class="form-group">' +
                                        '<div class="col-sm-4">ITEM TYPE</div>'+
                                        '<div class="col-sm-8">' +
                                            ' : <span class="text-blue">SONY-SW</span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                        '<div class="col-sm-4">SRP</div>' +
                                        '<div class="col-sm-8">' +
                                            ': <span class="text-blue"><input type="hidden" name="srp[]" class="" value="'+ item.srp +'">'+ item.srp +'</span>' +
                                        '</div>' +
                                    '</div>' +

                                    '<div class="form-group">' +
                                        '<div class="col-sm-4">REION</div>' +
                                        '<div class="col-sm-8">' +
                                            ': <span class="text-blue">R3</span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                        '<div class="col-sm-4">BARCODE' +
                                        '</div>' +
                                        '<div class="col-sm-8">' +
                                            barcodeItem +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-sm-6 detail">' +
                                    '<div class="form-group">' +
                                        '<div class="col-sm-4">' +
                                            '<strong>QTY</strong>' +
                                        '</div>' +
                                        '<div class="col-sm-8">' +
                                            '<input type="number" name="qty[]" value="1" style="width: 50px;">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<div class="col-sm-4">EDITION' +
                            '</div>'+
                            '<div class="col-sm-8">'+
                                ': <strong class="text-blue">STANDARD</strong>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<div class="col-sm-4">ZONE</div>'+
                            '<div class="col-sm-8">'+
                                '<div>: 2 <span class="text-blue">(EN)</span></div>'+
                                '<div>: <span class="text-blue">8-8888-88888-88-8</span></div>'+
                                '<div>: <span class="text-blue">9-9999-99999-99-9</span></div>'+
                            '</div>'+
                        '</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>'+
		'<div class="tag row">'+
			'<div class="col-sm-11 col-sm-offset-1">'+
				'<label class="trigger">Cull of duty<i class="close fa fa-times close-tag"></i></label>'+
				'<label class="trigger">Final Fantasy<i class="close fa fa-times close-tag"></i>'+
				'</label><input type="hidden" name="bundledItems[]" class="" value="">'+
			'</div>'+
		'</div>'+
	'</div>';

            $('#product-items').append(appendItem);
            $('#SEARCH').val('');
            $('#TotalPleces').html( $('.card').size() + ' <strong>Pleces</strong>');
        })
    });
    </script>
@endsection
