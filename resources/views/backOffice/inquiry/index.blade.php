@extends('layouts.backOffice.template-with-top-and-bottom-right-sidebar')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/inquiry/index.css')}}" />
<style>
      .text-undo{
        color: #ccc;
        text-decoration: line-through;
      }
      .text-href{
      	color: #3097d1;
      }
    </style>
@endsection

@section('module_name', 'INQUIRY')
@section('page_name', 'INDEX')

@section('body')
<div class="x_content">
  <section class="section-header-index">
    <form class="form-inline form-header-index" action="{{ route('backOffice.inquiry.index') }}" id="search-form" method="get">
      <input name="status" type="hidden" value="{{$request->input('status')}}">
      <div class="row">
        <table>
          <tr>
            <td class="col-1">
              <div class="col-1-content" >
                <div class="form-group select-all">
                  <input type="checkbox"  checked class="iCheck" id="selectall" name="selectall" >
                  <label for="selectall" class="iCheck-label" >Select All</label>
                </div>
                <div class="form-group">
                  <a class="btn btn-default-background" href="{{ url("back-office/inquiry/create") }}">
                    <span class="btn-label"><i class="fa fa-plus-square new" aria-hidden="true"></i></span ><span class="btn-label-label">NEW</span>
                  </a>
                </div>
                <div class="form-group button-2">
                  <button type="button"    class="btn btn-default-background">
                    <span class="btn-label"><span class="fa-approve-all"></span></span><span class="btn-label-label">Approve All</span>
                  </button>
				</div>
				<div class="form-group">
					<button type="button" class="btn  btn-default-background">
						<span class="btn-label"><i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i></i></span><span class="btn-label-label">NEW PO FROM ALL</span>
					</button>
				</div>
              </div>
            </td>
            <td class="col-2">
              <div class="" >
                <div class="form-group form-fixed-width" >
                  <div class="icon-addon addon-sm">
                    <input  type="text" placeholder="SEARCH" class="form-control search" id="SEARCH"  name='search'>
                    <label for="search"  class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>
                  </div>
                </div>
              </div>
            </td>
            <td class="col-3">

              <div class="text-right col-3-content">
                {{-- <div class="form-group">
                  <button type="button" class="btn  btn-default-background">
                    <span class="btn-label"><i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i></i></span><span class="btn-label-label">PDF</span>
                  </button>
                </div> --}}
                <div class="form-group">
                  <button type="button" class="btn  btn-default-background">
                    <span class="btn-label"><i class="fa fa-file-excel-o excel" aria-hidden="true"></i></i></span><span class="btn-label-label">Excel</span>
                  </button>
                </div>
                <div class="form-group">
                  <button type="button" class="btn  btn-default-background">
                    <span class="btn-label"><i class="fa fa-times-circle-o danger" aria-hidden="true"></i></span><span class="btn-label-label">Delete All</span>
                  </button>
                </div>
                <div class="form-group">
                  <div class="btn-group ngin-dropdown-sort">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-sort-alpha-desc"></i> SORT
                    </a>
                    <ul class="dropdown-menu dropdown-menu-form">
                      <li class="title">ORDER</li>
                      <li><input type="radio" id="radioAsc" name="rdoOrder" value="asc" @if($request->rdoOrder==='asc' || $request->rdoOrder=="") checked="checked" @endif><label for="radioAsc">Ascending</label></li>
                      <li><input type="radio" id="radioDes" name="rdoOrder" value="des" @if($request->rdoOrder==='des') checked="checked" @endif><label for="radioDes">Descending</label></li>
                      <li role="separator" class="divider"></li>
                      <li class="title">BY</li>
                      <li><input type="radio" id="radioId" name="rdoBy" checked="checked" value="id" @if($request->rdoBy==='id' || $request->rdoBy=="") checked="checked" @endif><label for="radioId">ID</label></li>
                      <li><input type="radio" id="radioDate" name="rdoBy" value="date_id" @if($request->rdoBy==='date_id') checked="checked" @endif><label for="radioDate">Date</label></li>
                      <li><input type="radio" id="radioSupplier" name="rdoBy" value="company_id" @if($request->rdoBy==='company_id') checked="checked" @endif><label for="radioSupplier">Supplier Name</label></li>
                      <li><input type="radio" id="radioBranch" name="rdoBy" value="branch_id" @if($request->rdoBy==='branch_id') checked="checked" @endif><label for="radioBranch">Branch Name</label></li>
                      <li><input type="radio" id="radioIsApprove" name="rdoBy" value="is_approve" @if($request->rdoBy==='is_approve') checked="checked" @endif><label for="radioIsApprove">Status </label></li>
                      <li><input type="radio" id="radioCreated" name="rdoBy" value="created_at" @if($request->rdoBy==='created_at') checked="checked" @endif><label for="radioCreated">Created at</label></li>
                    </ul>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </form>
	</section>


	<div id="exTab2">
		<ul class="nav nav-tabs">
			<li class="{{$request->input('status')=='pending'?'active':''}}">
				<a href="{{ route('backOffice.inquiry.index', 'status=pending') }}" >
					<span>
						<i class="fa fa-circle-o-notch" aria-hidden="true"></i>
					</span>
					PENDING FOR APPROVAL
				</a>
			</li>
			<li class="{{$request->input('status')=='approve' || $request->input('status')==''?'active':''}}">
				<a href="{{ route('backOffice.inquiry.index', 'status=approve') }}">
					<span>
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
					</span>
					APPROVED
				</a>
			</li>
			<li class="{{$request->input('status')=='partial'?'active':''}}">
				<a href="{{ route('backOffice.inquiry.index', 'status=partial') }}">
					<span>
						<i class="fa fa-hourglass-end" aria-hidden="true"></i>
					</span>
					PARTIAL
				</a>
			</li>
			<li class="{{$request->input('status')=='complete'?'active':''}}">
				<a href="{{ route('backOffice.inquiry.index', 'status=complete') }}">
					<span>
						<i class="fa fa-check" aria-hidden="true"></i>
					</span>
					COMPLETED
				</a>
			</li>
		</ul>

		<div class="tab-content scroll-2">
			<!--  tab  !-->
			<div class="tab-pane active" id="pending">
				<div class="panel-group " id="backlog" role="tablist" aria-multiselectable="true">
					
					@foreach($inquirys as $index => $inquiry)
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#backlog" href="#collapse{{$inquiry->id}}" aria-expanded="true" aria-controls="collapseOne">
									<table class="table ">
										<tbody>
											<tr>
												<td class="tr-checkbox">
													<input type="checkbox" class="iCheck" />
												</td>
												<td class="iq-colhead">
													<b>
														<div class="@if($inquiry->deleted_at) text-undo @endif">IQ#<span class="iq-number" >
														<a onclick="event.stopPropagation();window.location='{{ route('backOffice.inquiry.show',$inquiry->id) }}'" class="@if($inquiry->deleted_at) text-undo @else text-href @endif">
															{{$inquiry->id}}
														</a>	</span></div>
														@if( $inquiry->is_approve == 'approve')
														 <span class="iq-status @if($inquiry->deleted_at) text-undo @endif"><i class="iq-status-icon fa-approve-all"></i> APPROVE</span>
														@elseif($inquiry->is_approve == null)
															<div class="iq-status waiting @if($inquiry->deleted_at) text-undo @endif" ><i class="iq-status-icon fa-exclamation"></i> <span>WAIRING FOR APPROVE</span></div>
														@elseif($inquiry->is_approve == 'unapprove')
															<span class="iq-status @if($inquiry->deleted_at) text-undo @endif"><i class="iq-status-icon fa fa-times-circle-o text-danger"></i> REJECTED</span>
														@endif
													</b>
													<p style="font-size: 18px;" class="@if($inquiry->deleted_at) text-undo @endif">
														{{$inquiry->date->fullDate}}
													</p>
												</td>
												<td class="@if($inquiry->deleted_at) text-undo @endif">
													<b>SUPPLIER :</b> 
														@if(isset($inquiry->companies))
															{{$inquiry->companies->name}}
														@endif
													<p class="value">
														<b>BRANCH :</b>{{$inquiry->branch_id}}</p>
												</td>
												<td class="tr-data-small">
													<b class="@if($inquiry->deleted_at) text-undo @endif">ORDERED</b>
													<P class="@if($inquiry->deleted_at) text-undo @endif">{{$inquiry->total_quantity}}</P>
												</td>
												<td class="tr-data-small" >
													<b class="@if($inquiry->deleted_at) text-undo @endif">RECEIVED </b>
													<P class="@if($inquiry->deleted_at) text-undo @endif">{{$inquiry->total_quantity - $inquiry->total_backlog}}</P>
												</td>
												<td class="tr-data-small" >
													<b class="@if($inquiry->deleted_at) text-undo @endif">BACKLOG </b>
													<P class="@if($inquiry->deleted_at) text-undo @else ngin-red @endif">({{$inquiry->total_backlog}})</P>
												</td>
											</tr>

											<tr>
												<td></td>
												<td colspan="4">
													
                                                    <a class="btn btn-ngin btn-default edit" @if($inquiry->trashed()) style="display: none" @else href="{{ route('backOffice.inquiry.edit',$inquiry->id) }}" @endif>
                                                        <span class="btn-label">
                                                          <i class="fa fa-pencil-square-o success" aria-hidden="true"></i>
                                                      </span>Edit
                                                  </a>
													<button @if($inquiry->trashed()) 
														style="display: none"@else
														onclick="event.stopPropagation();window.location='{{ route('backOffice.inquiry.create', 'id='.$inquiry->id) }}'" @endif type="button" class="btn btn-ngin btn-default">
														<span class="btn-label">
															<i class="fa fa-files-o" aria-hidden="true"></i>
														</span>Duplicate
													</button>
													<button @if(!$inquiry->trashed()) 
														style="display: none"@endif type="button" class="btn btn-ngin btn-default btn-restore" data-action="{{ route('backOffice.inquiry.restore', $inquiry->id) }}">
														<span class="btn-label">
															<i class="fa fa-undo info" aria-hidden="true"></i>
														</span>Undo
													</button>
													<button type="button" data-action="{{ route('backOffice.inquiry.destroy', $inquiry->id) }}" class="btn btn-ngin btn-default btn-delete"
										                 @if($inquiry->trashed()) data-force-delete="1" @endif 
										                 >
									                      	<span class="btn-label">
																	<i class="fa fa-times-circle-o danger" aria-hidden="true"></i>
															</span>Delete
										                </button>
												</td>

												<td>
													<button @if($inquiry->trashed() || $inquiry->is_approve != 'approve') 
														style="display: none"@else 
														onclick="window.location='{{ route('backOffice.purchasing-order.create',$inquiry->id) }}'"
														 @endif type="button" class="btn btn-ngin btn-default">
														<span class="btn-label">
															<i class="fa fa-plus" aria-hidden="true"></i>
														</span>New PO
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</a>
							</h4>
						</div>
						<div id="collapse{{$inquiry->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body scroll-2">
								<table class="table ngin-table">
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
											<td class="text-center td-chart">
												<div class="char-total chart" data-percent="30" data-current="300" data-total="1000">
													<span class="chart-total-display"></span>
												</div>
												<div class="chart-label"><strong>TOTAL</strong></div>
											</td>
											<td class="text-center td-chart">
												<div class="char-first-time chart chart-time" data-percent="70" data-current="120" data-total="200">
													<span class="chart-time-display"></span>
												</div>
												<div class="chart-label">
													<div class="po-number">PO # <span class="text-blue">1212</span></div>
														<strong>01/08/2018</strong>
												</div>
											</td>
											<td class="text-center td-chart">
												<div class="char-first-time chart chart-time" data-percent="100" data-current="100" data-total="100">
													<span class="chart-time-display"></span>
												</div>
												<div class="chart-label">
													<div class="po-number">PO # <span class="text-blue">2323</span></div>
														<strong>11/08/2018</strong>
												</div>
											</td>
											<td class="text-center td-chart">
												<div class="char-first-time chart chart-time" data-percent="0" data-current="0" data-total="50">
													<span class="chart-time-display"></span>
												</div>
												<div class="chart-label">
													<div class="po-number">PO # <span class="text-blue">3434</span></div>
														<strong>22/08/2018</strong>
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

	{{$inquirys->appends(request()->input())->links()}}

	<form id="delete-form" method="post" >
        <input name="_method" type="hidden" value="DELETE">
        <input name="status" type="hidden" value="{{$request->input('status')}}">
        {!! csrf_field() !!}
                   
    </form>

    <form id="restore-form" method="post" >
        <input name="_method" type="hidden" value="PUT">
        <input name="status" type="hidden" value="{{$request->input('status')}}">
        {!! csrf_field() !!}
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
		@foreach($newReleaseProducts as $index => $newReleaseProduct)

			<li class="media event">
				<a class="pull-left border-aero">
					<img src="http://www.ngin.co.th/data/product/161221081830_prod_125.jpg" alt="" class="img-rounded">
				</a>
				<div class="media-body">
					<a class="title" href="#">{{$newReleaseProduct->name}}</a>
					<small class="right">20/50</small>
					<p style="overflow: hidden;max-height:38px;">
						<small >{{$newReleaseProduct->description}}</small>
					</p>
				</div>
			</li>
		@endforeach
	</ul>
</div>
@endsection

@section('script')
<script src="{{ asset('js/back-office/inquiry/index.js') }}"></script>
<script type="text/javascript">
	$('[name="rdoOrder"],[name="rdoBy"]').change(function(event) {
		console.log('search-form');
	  $("#search-form").submit();
	});

	$('.btn-delete').click(function(event) {
		event.stopPropagation();
	  if($(this).data('force-delete')!=null){
	    swal({
	    title: 'Are you sure?',
	    text: "Do you want to force delete?",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#cc0520',
	    confirmButtonText: 'Yes, delete it!'
	    }).then((result) => {
	      if (result.value) {
	           $("#delete-form").attr('action',$(this).data('action')) .submit();
	      }
	    })
	  }else{
	     $("#delete-form").attr('action',$(this).data('action')).submit();
	  }
	});

	$('.btn-restore').click(function(event) {
		event.stopPropagation();
		$("#restore-form").attr('action',$(this).data('action')).submit();
	});
</script>
@include('components.alert');
@endsection
