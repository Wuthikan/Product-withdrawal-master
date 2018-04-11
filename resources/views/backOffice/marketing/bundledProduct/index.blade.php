@extends('layouts.backOffice.template-with-top-and-bottom-right-sidebar')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/marketing/bundled-product/index.css')}}"/>
@endsection

@section('module_name', 'MODULE_NAME')
@section('page_name', 'PAGE_NAME')

@section('body')
<div class="container-fluid x_content">
    <section class="section-header-index">
        <form class="form-inline form-header-index">
            <div class="row">
                <table style="width: 100%">
                <tr>
                    <td class="col-1" style="min-width: inherit;width: 260px;">
                        <div class="col-1-content" >
                            <div class="form-group select-all">
                                <input type="checkbox" class="iCheck" id="selectall" name="selectall" >
                                <label for="selectall" class="iCheck-label" >Select All</label>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-default-background" href="{{ route("backOffice.marketing.bundled-product.create") }}">
                                    <span class="btn-label"><i class="fa fa-plus-square new" aria-hidden="true"></i></span ><span class="btn-label-label">NEW</span>
                                </a>
                            </div>
                            <div class="form-group button-2">
                                <button type="button"    class="btn btn-default-background">
                                    <span class="btn-label"><span class="fa-approve-all"></span></span><span class="btn-label-label">Approve All</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="col-2" style="width: inherit;">
                        <div class="" >
                            <div class="form-group form-fixed-width" >
                                <div class="icon-addon addon-sm">
                                    <input  type="text" placeholder="SEARCH" class="form-control search" id="search" name="search" value="{{Request::input('search')}}">
                                    <label for="search"  class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="col-3" style="min-width: inherit;width: 268px;">
                        <div class="text-right col-3-content">
                            <div class="form-group">
                                <button type="button" class="btn  btn-default-background">
                                <span class="btn-label"><i class="fa fa-file-pdf-o pdf" aria-hidden="true"></i></i></span><span class="btn-label-label">PDF</span>
                                </button>
                            </div>
                            <div class="form-group">
                                <a class="btn  btn-default-background" href="{{route('backOffice.marketing.bundled-product.index', ['excel'=>1])}}">
                                    <span class="btn-label">
                                        <i class="fa fa-file-excel-o excel" aria-hidden="true"></i>
                                    </span>
                                    <span class="btn-label-label">Excel</span>
                                </a>
                            </div>
                            <div class="form-group">
                                <button type="button"  class="btn  btn-default-background">
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
                                        <li>
                                            <input type="radio" id="radioAsc" name="order" checked="checked" value="asc"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => 'asc', 'sort'=> $sort]) }}'"
                                            @if($order=='asc') checked="checked" @endif>
                                            <label for="radioAsc">Ascending</label></li>
                                        <li>
                                            <input type="radio" id="radioDes" name="order" value="desc"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => 'desc', 'sort'=> $sort]) }}'"
                                            @if($order=='desc') checked="checked" @endif>
                                            <label for="radioDes">Descending</label>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li class="title">BY</li>
                                        <li>
                                            <input type="radio" id="radioId" name="sort" value="id"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => $order, 'sort'=> 'id']) }}'"
                                            @if($sort=='id') checked="checked" @endif>
                                            <label for="radioId">ID</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radioBundledName" name="sort" value="bundled_name"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => $order, 'sort'=> 'bundled_name']) }}'"
                                            @if($sort=='bundled_name') checked="checked" @endif>
                                            <label for="radioBundledName">Bundled Name</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radioStartDate" name="sort" value="start_date_id"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => $order, 'sort'=> 'start_date_id']) }}'"
                                            @if($sort=='start_date_id') checked="checked" @endif>
                                            <label for="radioStartDate">Start Date</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radioEndDate" name="sort" value="end_date_id"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => $order, 'sort'=> 'end_date_id']) }}'"
                                            @if($sort=='end_date_id') checked="checked" @endif>
                                            <label for="radioEndDate">End Date</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radioPromotionSrp" name="sort" value="promotion_srp"
                                            onclick="location.href='{{ route('backOffice.marketing.bundled-product.index', ['order' => $order, 'sort'=> 'promotion_srp']) }}'"
                                            @if($sort=='promotion_srp') checked="checked" @endif>
                                            <label for="radioPromotionSrp">Promotion Srp</label>
                                        </li>
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
    
    <section>
        @if($products->total() == 0)
        <div align="center">DATA NOT FOUND.</div>
        @else
        <div class="panel-content scroll-2 bundled-contain">
            <div style="padding-right: 20px">
                @foreach($products as $i => $data)
                <div class="panel panel-default">
                <div class="panel-heading {{($data->trashed())?'is-trashed':''}}" role="tab" id="heading{{$i}}">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" aria-expanded="{{$i==0?'true':'false'}}" aria-controls="collapse{{$i}}">
                        <div class="detial"> 
                            <div class="row" style="align-items: center; display: flex;">
                                <div class="col-xs-4">
                                    <table width="100%">
                                        <tr>
                                            <td class="checkboxCtl">
                                                <div class="records__check">
                                                    <input type="checkbox" name="item[]" class="iCheck item" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="{{($data->trashed())?'is-trashed bundleTrashed bundleNameTrashed':'bundleName'}}">
                                                    {{$data->bundled_name}}
                                                </div>
                                                <div class="{{($data->trashed())?'is-trashed bundleTrashed bundlePriceTrashed':'bundlePrice'}}">
                                                    <!-- 125 THB -->
                                                    {{number_format($data->promotion_srp, 2)}}
                                                </div> 
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-xs-3">
                                    <div class="{{($data->trashed())?'is-trashed dateTrashed dateTextTrashed':'dateText'}}">START - END</div>
                                    <div class="{{($data->trashed())?'is-trashed dateTrashed dateBoxTrashed':'dateBox'}}">
                                        {{$data->startDate->fullDate}} - {{$data->endDate->fullDate}}
                                    </div>
                                </div>

                                <div class="col-xs-3 text-center">
                                    @if($data->trashed())
                                    <div class="dateTrashed">
                                    @else
                                    <div class=
                                        {{ $data->is_approve === 0 ? 'dateColor1' : '' }}
                                        {{ $data->is_approve === null ? 'dateColor2' : '' }}
                                        {{ $data->is_approve === 1 ? 'dateColor3' : '' }}
                                    >
                                    @endif
                                    {{ $data->is_approve === 0 ? 'REJECTED' : '' }}
                                    {{ $data->is_approve === null ? 'WAITTING FOR APPROVAL' : '' }}
                                    {{ $data->is_approve === 1 ? 'APPROVED' : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="collapse{{$i}}" class="panel-collapse collapse {{$i==0?'in':''}} {{($data->trashed())?'is-trashed':''}}" role="tabpanel" aria-labelledby="heading{{$i}}">
                    <div class="panel-body">
                        <div class="bundleBox">
                            <div class="bundleContent">
                                <div class="bundleDetail">
                                    <div class="bundleDescription">
                                    <div class="marginBottom-space">
                                        <span class="{{($data->trashed())?'boldTrashed':'bold'}}">
                                        REMARK : 
                                        </span>
                                        <span class="detail" style="margin-left: 20px;">
                                        {{$data->remark}}
                                        </span>
                                    </div>
                                    <div class="marginBottom-space">
                                        <span class="{{($data->trashed())?'boldTrashed':'bold'}}">
                                        ราคา TIER : 
                                        </span>
                                        <span class="detail"> 
                                            <span id="tier" class="{{($data->trashed())?'colorTrashed':'colorGreen'}}">GD 1,590 บาท</span>
                                            <span id="tier" class="{{($data->trashed())?'colorTrashed':'colorBlue'}}">PAD 1,590 บาท</span>
                                            <span id="tier" class="{{($data->trashed())?'colorTrashed':'colorOrange'}}">MT 1,590 บาท</span>
                                        </span>
                                    </div>
                                    </div>
                                    <div class="bundleItems">
                                        <div class="itemScroll">
                                            <ul>
                                            @for($iItem = 0; $iItem < 10; $iItem++)
                                            <li>
                                                @if($data->trashed())
                                                <img cl src="{{Image::make('https://static-cdn.jtvnw.net/ttv-boxart/Dota%202-138x190.jpg')->greyscale()->encode('data-url')}}" class="profilePicture" />
                                                @else
                                                <img src="https://static-cdn.jtvnw.net/ttv-boxart/Dota%202-138x190.jpg" alt="dota 2">
                                                @endif
                                                <div class="{{($data->trashed())?'is-trashed bundleItemNameTrashed':'bundleItemName'}}">Dota 2</div>
                                                <div class="{{($data->trashed())?'is-trashed':'bundleItemPrice'}}">10 BAHT</div>
                                            </li>
                                            <!-- end bundle item -->
                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="bundleAction">
                                    @if(!$data->trashed())
                                    <a class="btn btn-ngin btn-default"href="{{route('backOffice.marketing.bundled-product.edit', $data->id)}}">
                                    <span class="btn-label">
                                        <i class="fa fa-pencil-square-o success" aria-hidden="true"></i>
                                    </span>Edit
                                    </a>
                                    @endif

                                    @if(!$data->trashed())
                                    <button type="button" class="btn btn-ngin btn-default" onclick="window.location='{{route('backOffice.marketing.bundled-product.create', ['id'=>$data->id])}}'">
                                        <span class="btn-label">
                                            <i class="fa fa-files-o" aria-hidden="true"></i>
                                        </span>Duplicate
                                    </button>
                                    @endif

                                    @if($data->trashed())
                                    <form action="{{ route('backOffice.marketing.bundled-product.restore', $data->id) }}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('put')}}
                                        <button type="submit" class="btn btn-ngin btn-default">
                                            <span class="btn-label">
                                            <i class="fa fa-undo info" aria-hidden="true"></i>
                                            </span>Undo
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form id="delete{{ $data->id }}" action="{{ route('backOffice.marketing.bundled-product.destroy', $data->id) }}" method="post" class="submitDelete">
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                        @if($data->trashed())
                                        <input type="hidden" name="_force" value="true">
                                        @endif

                                        @if(!$data->trashed())
                                        <button type="submit" class="btn btn-ngin btn-default">
                                            <span class="btn-label">
                                            <i class="fa fa-times-circle-o ngin-red" aria-hidden="true"></i>
                                            </span>Delete
                                        </button>
                                        @else
                                        <button type="button" onclick="ForceDelete({{ $data->id }})" class="btn btn-ngin btn-default">
                                            <span class="btn-label">
                                            <i class="fa fa-times-circle-o ngin-red" aria-hidden="true"></i>
                                            </span>Delete
                                        </button>
                                        @endif
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>

{{$products->links()}}
</div>
@endsection

@section('top-right-sidebar')
@endsection

@section('script')
    <script src="{{ asset('js/back-office/marketing/bundled-product/index.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Set Label Header Page
            $('#lbHeaderPage').html("<h3>BUNDLED PRODUCTS | <span>INDEX</span></h3>");
        });

        function ForceDelete(id){
            swal({
                title: 'Are You Sure ?',
                text: "มีข้อมูลที่จะถูกลบถาวร!!",
                type: 'warning',
                confirmButtonColor: '#d60500',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $('#delete'+id).submit()
                }
            });
        
        }
    </script>
@include('components/alert');
@endsection
