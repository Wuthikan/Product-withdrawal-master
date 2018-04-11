@extends('layouts.backOffice.template-with-top-and-bottom-right-sidebar')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/purchasing-order/index.css')}}"/>
@endsection

@section('module_name', 'PURCHASING ORDER (PO)')
@section('page_name', 'INDEX')

@section('body')
<div class="x_content">
	<section class="section-header-index">
	<form id="search-form" class="form-inline form-header-index"  action="{{ route('backOffice.purchasing-order.index') }}" method="get">
	  <div class="row">
		<table>
		  <tr>
			<td class="col-1" style="min-width: 10% !important; width: 12% !important;">
			  <div class="col-1-content" >
				<div class="form-group select-all">
				  <input type="checkbox" id="selectAll">
				  <label for="selectAll" class="iCheck-label" >Select All</label>
				</div>
				<div class="form-group">
				  <a class="btn btn-default-background" href="{{ url("back-office/purchasing-order/create") }}">
					<span class="btn-label"><i class="fa fa-plus-square new" aria-hidden="true"></i></span ><span class="btn-label-label">NEW</span>
				  </a>
				</div>

			  </div>
			</td>
			<td class="col-2" style="width: 70% !important;">
			  <div class="" >
				<div class="form-group form-fixed-width" >
				  <div class="icon-addon addon-sm">
					<input type="text" placeholder="SEARCH" class="form-control search" name="search" @if(isset($_GET['search'])) value="{{$_GET['search']}}"@endif />
					<label  class="glyphicon glyphicon-search"  rel="tooltip" title="email"></label>
				  </div>
				</div>
			  </div>
			</td>
			<td class="col-3">

			  <div class="text-right col-3-content">

				<div class="form-group">
				  <button type="button" class="btn  btn-default-background btn-excel">
					<span class="btn-label"><i class="fa fa-file-excel-o excel" aria-hidden="true"></i></i></span><span class="btn-label-label">Excel</span>
				  </button>
				</div>
				<div class="form-group">
				  <button type="button" class="btn  btn-default-background" id="deleteAll">
					<span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i></span><span class="btn-label-label">Delete All</span>
				  </button>
				</div>
				<div class="form-group">
				  <div class="btn-group ngin-dropdown-sort">
					<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-sort-alpha-desc"></i> SORT
					</a>
					<ul class="dropdown-menu dropdown-menu-form" >
					  <li class="title">ORDER</li>
					  <li><input type="radio" id="radioAsc" name="rdoOrder"  value="asc" @if(app('request')->input('rdoOrder')=="asc" || !app('request')->input('rdoOrder')) checked="checked" @endif ><label for="radioAsc">Ascending</label></li>
					  <li><input type="radio" id="radioDes" name="rdoOrder"  value="desc" @if(app('request')->input('rdoOrder')=="desc") checked="checked" @endif><label for="radioDes">Descending</label></li>
					  <li role="separator" class="divider"></li>
					  <li class="title">BY</li>
					  <li><input type="radio" id="radioId" name="rdoBy" value="id" @if(app('request')->input('rdoBy')=="id" || !app('request')->input('rdoBy')) checked="checked" @endif ><label for="radioId">ID</label></li>
					  <li><input type="radio" id="radioCompany" name="rdoBy" value="company" @if(app('request')->input('rdoBy')=="company") checked="checked" @endif ><label for="radioCompany">Company</label></li>
					  <li><input type="radio" id="radioDocumentDate" name="rdoBy" value="documentDate" @if(app('request')->input('rdoBy')=="documentDate") checked="checked" @endif ><label for="radioDocumentDate">Document Date</label></li>
					  <li><input type="radio" id="radioShippingDate" name="rdoBy" value="shippingDate" @if(app('request')->input('rdoBy')=="shippingDate") checked="checked" @endif ><label for="radioShippingDate">Shipping Date</label></li>
					  <li><input type="radio" id="radioTotalQuantity" name="rdoBy" value="totalQuantity" @if(app('request')->input('rdoBy')=="totalQuantity") checked="checked" @endif ><label for="radioTotalQuantity">Total Quantity</label></li>
					  <li><input type="radio" id="radioBacklogQuantity" name="rdoBy" value="backlogQuantity" @if(app('request')->input('rdoBy')=="backlogQuantity") checked="checked" @endif ><label for="radioBacklogQuantity">Backlog Quantity</label></li>
					</ul>
				  </div>
				</div>
			  </div>
			</td>
		  </tr>
		</table>
	  </div>
	  <input name="approve" type="hidden" value="{{ ( app('request')->input('approve') ) ? app('request')->input('approve') : 'partial' }}">
	</form>
	</section>

	<div id="exTab2" class="">
		<ul class="nav nav-tabs">
			<li class="{{ $purchasing_orders->approve ==  'pending' ? 'active' : ''  }}">
				<a href="{{ route('backOffice.purchasing-order.index', ['approve' => 'pending']) }}">
					<span>
						<i class="fa fa-circle-o-notch" aria-hidden="true"></i>
					</span>
					PENDING FOR APPROVAL
				</a>
			</li>
			<li class="{{ $purchasing_orders->approve ==  'approve' ? 'active' : ''  }}">
				<a href="{{ route('backOffice.purchasing-order.index', ['approve' => 'approve']) }}">
					<span>
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
					</span>
					APPROVED
				</a>
			</li>
			<li class="{{ $purchasing_orders->approve ==  'partial' || $purchasing_orders->approve == null ? 'active' : ''  }}">
				<a href="{{ route('backOffice.purchasing-order.index', ['approve' => 'partial']) }}">
					<span>
						<i class="fa fa-hourglass-end" aria-hidden="true"></i>
					</span>
					PARTIAL
				</a>
			</li>
			<li class="{{ $purchasing_orders->approve ==  'complete' ? 'active' : ''  }}">
				<a href="{{ route('backOffice.purchasing-order.index', ['approve' => 'complete']) }}">
					<span>
						<i class="fa fa-check" aria-hidden="true"></i>
					</span>
					COMPLETED
				</a>
			</li>
		</ul>
		<div class="tab-content scroll-2">
			<div class="tab-pane active">
				<div class="panel-group" id="backlog" role="tablist" aria-multiselectable="true">
					@foreach($purchasing_orders as $purchasing_order)
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading{{ 'A'.$purchasing_order->id }}">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#backlog" href="#collapse{{ 'A'.$purchasing_order->id }}" aria-expanded="true" aria-controls="collapse{{ 'A'.$purchasing_order->id }}">
									<!-- <a role="button"> -->
									<table class="table inquiry-collape">
										<tbody>
											<tr>
												<td class="tr-checkbox">
													<input type="checkbox" name="checked[]" value="{{ $purchasing_order->id }}"/>
													<!-- <input type="checkbox" class="iCheck" name="checked[]" value="{{ $purchasing_order->id }}"/> -->
												</td>
												<td>
													<div class="iq-number">
														<strong class="number" onclick="location.href='{{ url("back-office/purchasing-order/$purchasing_order->id") }}'">PO#<span>{{ $purchasing_order->id }}</span></strong>
														<div class="doc-date">DOCUMENT DATE<br/>{{ $purchasing_order->documentDate->date }}/{{ $purchasing_order->documentDate->month }}/{{ $purchasing_order->documentDate->year }}</div>
													</div>
													<label>{{ $purchasing_order->company->name}} ({{$purchasing_order->branch->name}})</label>
												</td>
												<td>
													<label>IQ #</label>
													<div  style="font-size: 14px;">
														@if(!empty($purchasing_order->inquiry_purchasing_orders))
															@foreach($purchasing_order->inquiry_purchasing_orders as $key => $inquiry_purchasing_order)
																@if($key != sizeof($purchasing_order->inquiry_purchasing_orders) - 1)
																	<span class="text-blue">{{ $inquiry_purchasing_order->id }} </span>,
																@else
																	<span class="text-blue">{{ $inquiry_purchasing_order->id }}</span>
																@endif
															@endforeach
														@endif
													</div>
												</td>
												<td>
													<label>DELIVARY DATE</label>
													<div>
														{{ $purchasing_order->shippingDate->date }}/{{ $purchasing_order->shippingDate->month }}/{{ $purchasing_order->shippingDate->year }}
													</div>
												</td>
												<td>
													<label>ORDERED</label>
													<div>
														1000
													</div>
												</td>
												<td>
													<label>RECEIVE</label>
													<div>
														350
													</div>
												</td>
												<td>
													<label>BACKLOG</label>
													<div class="ngin-red">
															(650)
													</div>
												</td>
											</tr>

											<tr>
												<td></td>
												<td colspan="5">
													<a class="btn btn-ngin btn-default" href="{{ url("back-office/purchasing-order/$purchasing_order->id/edit") }}">
														<span class="btn-label">
															<i class="fa fa-pencil-square-o success" aria-hidden="true"></i>
														</span>Edit
													</a>
													<button type="button" class="btn btn-ngin btn-default">
														<span class="btn-label">
															<i class="fa fa-files-o" aria-hidden="true"></i>
														</span>Duplicate
													</button>
													@if($purchasing_order->trashed())
														<form action="{{ route('backOffice.purchasing-order.restore', $purchasing_order->id) }}" method="post" style="display:  inline-block;">
															<input name="_method" type="hidden" value="put">
															{!! csrf_field() !!}
															<button type="submit" class="btn btn-ngin btn-default" data-action="{{ route('backOffice.purchasing-order.restore', $purchasing_order->id) }}">
																<span class="btn-label">
																	<i class="fa fa-undo info" aria-hidden="true"></i>
																</span>Undo
															</button>
														</form>
													@endif
													<form id="{{ 'delete-form'.$purchasing_order->id }}" action="{{ route('backOffice.purchasing-order.destroy', $purchasing_order->id) }}" method="post" style="display:  inline-block;">
														<input name="_method" type="hidden" value="delete">
														{!! csrf_field() !!}
														<button type="button" class="btn btn-ngin btn-default" onclick="deleteWaringAlert('{{ $purchasing_order->trashed() }}','{{ $purchasing_order->id }}')">
															<span class="btn-label">
																<i class="fa fa-times-circle-o ngin-red" aria-hidden="true"></i>
															</span>Delete
														</button>
													</form>
												</td>
												@if ($purchasing_order->is_approve === null)
													<td>
														<div class="iq-status waiting"><i class="iq-status-icon fa-exclamation"></i> <span>WAITING FOR APPROVE</span></div>
													</td>
												@elseif ($purchasing_order->is_approve == 1)
													<td>
														<span class="iq-status"><i class="iq-status-icon fa-approve-all"></i> APPROVE</span>
													</td>
												@elseif ($purchasing_order->is_approve == 0)
													<td>
														<span class="iq-status"><i class="iq-status-icon text-danger fa fa-times-circle-o"></i>REJECTED</span>
													</td>
												@endif
											</tr>
										</tbody>
									</table>
								</a>
							</h4>
						</div>
						<div id="collapse{{ 'A'.$purchasing_order->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ 'A'.$purchasing_order->id }}">
							<div class="panel-body scroll-2">

									<table class="table iq-detail-table ngin-table">
										<thead>
											<tr>
												<th>ORDERED</th>
												<th>RECEIVED</th>
												<th>RECEIVED DATE</th>
												<th>PR</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>200</td>
												<td>50</td>
												<td>02/09/2017</td>
												<td class="td-pr">1111</td>
											</tr>
											<tr>
												<td></td>
												<td>50</td>
												<td>01/09/2017</td>
												<td class="td-pr">2222</td>
											</tr>
											<tr>
												<td></td>
												<td>10</td>
												<td>29/08/2017</td>
												<td class="td-pr">3333</td>
											</tr>
											<tr>
												<td></td>
												<td>10</td>
												<td>28/08/2017</td>
												<td class="td-pr">4444</td>
											</tr>
											<tr>
												<td>100</td>
												<td>100</td>
												<td>27/08/2017</td>
												<td class="td-pr">5555</td>
											</tr>
											<tr class="border-bottom">
												<td>50</td>
												<td>0</td>
												<td>26/08/2017</td>
												<td class="td-pr">6666</td>
											</tr>
											<tr>
												<td colspan="4" style="text-align: center;">
													<div class="row">
														<div class="col-xs-3">
															<div class="row">
																<div class="col-xs-12">
																	<span class="char-total chart" data-percent="30" data-current="300" data-total="1000">
																		<span class="chart-total-display"></span>
																	</span>
																</div>
															</div>
															<div class="row">
																<div class="col-xs-12">
																	<label class="chart-label">TOTAL</label>
																</div>
															</div>
														</div>

														<div class="col-xs-3">
															<div class="row">
																<div class="col-xs-12">
																	<span class="char-first-time chart chart-time" data-percent="60" data-current="120" data-total="200">
																		<span class="chart-time-display"></span>
																	</span>
																</div>
															</div>
															<div class="row">
																<div class="col-xs-12 col-label-time">
																	<label class="chart-label">
																		<p class="po-number">PO # <span class="text-blue">1212</span></p>
																		01/08/2017
																	</label>
																</div>
															</div>
														</div>

														<div class="col-xs-3">
															<div class="row">
																<div class="col-xs-12">
																	<span class="char-second-time chart chart-time" data-percent="100" data-current="100" data-total="100">
																		<span class="chart-time-display"></span>
																	</span>
																</div>
															</div>
															<div class="row">
																<div class="col-xs-12 col-label-time">
																	<label class="chart-label">
																		<p class="po-number">PO # <span class="text-blue">2323</span></p>
																		11/08/2017
																	</label>
																</div>
															</div>
														</div>

														<div class="col-xs-3">
															<div class="row">
																<div class="col-xs-12">
																	<span class="char-third-time chart chart-time" data-percent="0" data-current="0" data-total="50">
																		<span class="chart-time-display"></span>
																	</span>
																</div>
															</div>
															<div class="row">
																<div class="col-xs-12 col-label-time">
																	<label class="chart-label">
																		<p class="po-number">PO # <span class="text-blue">3434</span></p>
																		22/08/2017
																	</label>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>

							</div>
						</div>
					</div>
					@endforeach

				</div>
			</div>
		</div>

	</div>
	<div class="row page-showing-pagination">
		<div class="col-xs-12 page-pagination">
			{!! $purchasing_orders->appends(Request::except('page'))->render() !!}
		</div>
	</div>
	<form id="delete-all-form" method="post" action="{{ route('backOffice.purchasing-order.destroy-many') }}">
		<input name="_method" type="hidden" value="delete">
		{!! csrf_field() !!}
		<input type="hidden" name="deleteAllChecked"/>
	</form>

</div>
@endsection


@section('top-right-sidebar')
<div class="x_title">
	<span class="left">Top Product เดือนที่แล้ว</span>
	<span class="right"></span>
</div>
<div class="x_content">
	<ul class="list-unstyled  scroll-view">
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>

			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/150727114252_prod_50.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/150727114252_prod_50.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
	</ul>
</div>
@endsection
@section('bottom-right-sidebar')
<div class="x_title">
	<span class="left">NEW RELEASES</span>
</div>
<div class="x_content">
	<ul class="list-unstyled  scroll-view">
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/150727114252_prod_50.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/150727114252_prod_50.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
				</p>
			</div>
		</li>
		<li class="media event">
			<a class="pull-left border-aero">
				<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
			</a>
			<div class="media-body">
				<a class="title" href="#">Horizon: Zero Dawn</a>
				<small class="right">20/50</small>
				<p>
					<small>Lorem ipsum dolor Lorem ipsum dolor adipiscing elit,...</small>
			</div>
		</li>
	</ul>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/back-office/templates/ellipsis/jquery.ellipsis.min.js') }}"></script>
	<script src="{{ asset('js/back-office/purchasing-order/index.js') }}"></script>

	<script>
		$('[name="rdoOrder"],[name="rdoBy"]').change(function(event) {
			$("#search-form").submit();
		});

		$( "#deleteAll" ).click(function() {
			var array = [];

			$("input[name='checked[]']:checked:enabled").each(function(index, value) {
				array.push($(this).val());
			});

			$("input[name='deleteAllChecked']").val(array);

			$("#delete-all-form").submit();
		});

		$('#selectAll').click(function () {
		    $('input:checkbox').prop('checked', this.checked);
		});

		function deleteWaringAlert( trashed, id ){
			if(trashed == true){
				swal({
					title: 'Are you sure?',
					text: "Do you want to delete?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#cc0520',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.value) {
						$("#delete-form"+id).submit();
					}
				})
			} else {
				$("#delete-form"+id).submit();
			}
		};
	</script>
@endsection
