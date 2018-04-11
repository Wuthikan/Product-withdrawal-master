@extends('layouts.backOffice.template')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/inquiry/create.css')}}"/>
@endsection

@section('module_name', 'INQUIRY')
@section('page_name', 'CREATE')

@section('body')
<div class="x_title scroll-2" id='inquiry-create'>
	<div class="x_content">
		@if(count($errors) > 0)
          {{-- <div class="alert alert-danger">
              <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
            </div> --}}

          {{-- <div style="color:red;font-weight:bold"> --}}
          @foreach($errors->all() as $error)
           <div class="alert alert-danger">
              <strong>Danger!</strong> {{ $error }}
            </div>
          {{-- <p>{{ $error }}</p> --}}
          @endforeach
          {{-- </div> --}}
        @endif
		<form action="{{ route('backOffice.inquiry.store') }}" method="POST" enctype="multipart/form-data">
			{!! csrf_field() !!}
			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-3 doc-date">
						<div class="form-group">
							<label for="datetimepicker">DOCUMENT DATE</label>
							<div class='input-group date' id='datetimepicker' >
								<input type='text' class="form-control" value="{{old('date')}}" name='date'/>
								<span class="input-group-addon">
									<i class="fa fa-calendar" ></i>
								</span>
							</div>
						</div>
					</div>
					<div class="col-xs-9 supplier">
						<div class="form-group">
							<label for="supplier_name">SUPPLIER</label>
							<input type="text" id="supplier_name" class="form-control"  data-action="typeaheadCustomer" placeholder="ID SUPPLIER" name="company_id" value="{{old('company_id')}}">
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<table class="table ngin-table scroll">
						<thead>
							<tr>
								<th class="w-250 text-left code-name"><span>BARCODE | PRODUCT CODE | ITEM NAME</span></th>
								<th class="w-100 text-center">WAREHOUSE</th>
								<th class="w-100 text-center">TYPE</th>
								<th class="w-1200">IN STOCK</th>
								<th class="w-100">BACKLOG<br/>FROM PREV. INQ.</th>
								<th class="w-70">QTY</th>
								<th class="w-70">UNIT PRICE <span class="text-light">(USD)</span></th>
								<th class="w-70">AMOUNT <span class="text-light">(USD)</span></th>
								<th class="w-250 col-itemname">REMARKS</th>
							</tr>
						</thead>
						<tbody class="scroll-2" >
							{{-- @for ($i = 0; $i <= 2; $i++) --}}
								<!--1 row  !-->
								<tr v-for="(product,index) in products">
									<td class="w-300 col-itemname">
										<div class="col-sm-1" >
											<button type="button" v-if="products.length >1 && index < products.length-1" class="btn btn-default-background" v-on:click="deleteProduct(index)">
												<span class="btn-label">
													<i class="fa fa-trash danger" aria-hidden="true"></i>
												</span>
											</button>
										</div>
										<div class="col-sm-11">
											<input :name="'products[' + index + '][id]'" type="text" class="form-control" placeholder="ID PRODUCT" data-action="typeaheadProduct" v-model="product['name']">
										</div>
									</td>
									<td class="w-100">
										<select id="basic" class="form-control" :name="'products[' + index + '][warehouse_id]'" >
											<option value="" >-- select warehouse --</option>
											@foreach($warehouses as $warehouse)
												<option value="{{ $warehouse->id }}" @if(isset($inquiry) &&$inquiry->warehouse->id == $warehouse->id) selected="selected" @endif>
													{{ $warehouse->name }}
												</option>
											@endforeach
										</select>
									</td>
									<td class="w-100">
										<select class="form-control" :name="'products[' + index + '][type_id]'">
											<option value="" >-- select type --</option>
											@foreach($types as $type)
												<option value="{{ $type->id }}" @if(isset($inquiry) &&$inquiry->type->id == $type->id) selected="selected" @endif>
													{{ $type->type }}
												</option>
											@endforeach
										</select>
									</td>
									<td class="w-100 balance">10</td>
									<td class="w-100 balance">10</td>
									<td class="w-70">
										<input type="number" class="form-control text-center" id="input" placeholder="input" :name="'products[' + index + '][quantity]'" v-model="product['quantity']">
									</td>
									<td class="w-70">
										<input type="number" step="0.01" class="form-control text-center" id="input" placeholder="input" :name="'products[' + index + '][unit_price]'" v-model="product['unit_price']">
									</td>
									<td class="w-70">
										<input type="number" class="form-control text-center" id="input" :name="'products[' + index + '][amount]'" v-model="product['amount']" placeholder="input">
									</td>
									<td class="w-250 col-itemname">
										<input type="text" class="form-control" :name="'products[' + index + '][remark]'" placeholder="input">
									</td>
								</tr>


								<!--end row  !-->
							{{-- @endfor --}}


								<!--1 row  !-->
							{{-- <tr>
								<td class="w-250 col-itemname">
									<div class="col-sm-1">&nbsp;</div>
									<div class="col-sm-11">
										<input type="text" class="form-control" placeholder="PRODUCT" data-action="typeaheadProduct">
									</div>
								</td>
								<td class="w-100">
									<select id="basic" class="form-control">
										<option value="">-- select warehouse --</option>
										@foreach($warehouses as $warehouse)
											<option value="{{ $warehouse->id }}" @if(isset($inquiry) &&$inquiry->warehouse->id == $warehouse->id) selected="selected" @endif>
												{{ $warehouse->name }}
											</option>
										@endforeach
										<option>WAREHOUSE-1</option>
										<option>WAREHOUSE-2</option>
										<option>WAREHOUSE-3</option>
										<option>WAREHOUSE-4</option>
										<option>WAREHOUSE-5</option>
										<option>WAREHOUSE-6</option>
									</select>
								</td>
								<td class="w-100">
									<select class="form-control">
										<option>USED</option>
										<option>NEW</option>
										<option>REPEAT</option>
									</select>
								</td>
								<td class="col-xs-2">&nbsp;</td>
								<td class="col-xs-2">&nbsp;</td>
								<td class="col-xs-1">
									<input type="text" class="form-control" id="input" placeholder="" value="">
								</td>
								<td class="col-xs-1">
										<input type="text" class="form-control" id="input" placeholder="" value="">
									</td>
								<td class="col-xs-2">
									<input type="text" class="form-control">
								</td>
								<td class="col-xs-3">
									<input type="text" class="form-control" id="input" placeholder="" value="">
								</td>
							</tr> --}}

								<!--end row  !-->
						</tbody>
						<tfoot>
						<tr>
							<td colspan="10">
								<div class="row">
									<div class="col-md-6">
										<p style="font-size: 13px; margin-bottom: 0px;"><strong>REMARK</strong></p>
										<textarea class="form-control" rows="7" name="remark"></textarea>
									</div>
									<div class="col-md-6 text-right">
										<span>Total</span> @{{total_price}} <span>Prices</span>
									</div>
								</div>
								
							</td>
						</tr>
					</table>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px;">
					<div class="actions">
						<button type="submit" class="btn btn-ngin btn-default">
							<span class="btn-label"><i class="fa fa-floppy-o success" aria-hidden="true"></i></span>SAVE </button>
						<button type="button" class="btn btn-ngin btn-default">
							<span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i></span>CANCEL</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/back-office/inquiry/create.js') }}"></script>
<script type="text/javascript">
	var app = new Vue({
	  el: '#inquiry-create',
	  data: {
	   	products: [{
	   		'name':null,
	   		'quantity':null,
	   		'unit_price':null,
	   		'amount':null
	   	}],
	   	total_price:0
	  },
	  methods:{
	  	addProduct : function(){
	  		this.products.push({name:null,quantity:null,unit_price:null,amount:null});
	  	},
	  	deleteProduct : function(index){
	  		this.products.splice(index,1)
	  	}
	  },
	   watch: {
	    products: {
	    	handler: function (val) {
	    		vm = this;
	    		if(this.products[this.products.length-1].name != null && this.products[this.products.length-1].name != ''){
	    			this.products.push({name:null});
	    		}
	    		vm.total_price=0;
	    		val.forEach(function(product,index) {
				  if(product.name && product.unit_price && product.quantity){
				  	
				  	vm.total_price += (parseInt(product.unit_price) * parseInt(product.quantity))
				  }
				});
	    		

			},
			deep: true
	    },
	  },
	})
</script>
@endsection
