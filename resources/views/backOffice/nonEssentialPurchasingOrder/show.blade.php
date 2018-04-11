@extends('layouts.backOffice.template-with-right-sidebar')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/back-office/purchasing-order/show.css')}}"/>
@endsection

@section('module_name', 'PURCHASING ORDER (PO)')
@section('page_name', 'SHOW')

@section('body')
<div class="x_content contentBox">
<div class="content scroll-2">
    <section>
        <h4 class="text-black"><strong>NEPO #{{ $NonEssentialPurchasingOrders->id}}</strong></h4>
        <div align="center">
            <img src="{{asset('images/logo.png')}}" alt="" style="max-width: 100px;">
            <br>
            <p class="text-uppercase"><h3>{{ $NonEssentialPurchasingOrders->document_date_id }}</h3></p>
        </div>
        <p>
            <table style="width: 100%; max-width: 300px;">
                <tr>
                    <td style="width: 30px; vertical-align: top;"><strong class="text-uppercase">TO:</strong></td>
                    <td>
                        <p>Client id {{ $NonEssentialPurchasingOrders->client_id }}</p>
                        <p>
                            ****************
                        </p>
                        <p class="text-small">
                            {{ $NonEssentialPurchasingOrders->billing_address }}
                        </p>
                    </td>
                </tr>
            </table>
        </p>
        <p style="font-weight: bold; text-indent: 30px;">******************** "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
    </section>
    <section style="padding-top: 20px">
        <table class="table itemList">
            <thead>
                <tr>
                    <th class="itemCode">CODE</th>
                    <th>DESCRIPTION</th>
                    <th class="itemValue">QTY</th>
                    <th class="itemValue">PRICE</th>
                    <th class="itemValue">DISCOUNT</th>
                </tr>
            </thead>
            <tbody>
                @php ($i = 0)
                @foreach($NonEssentialPurchasingOrders->FactNonEssentialPurchasingOrders as $FactNonEssentialPurchasingOrder)
                <tr>
                    <td align="center">{{ $FactNonEssentialPurchasingOrder->product_id }}</td>
                    <td>
                        @if($i==0) <strong class="text-black">PGS4-G : </strong>@endif Lorem ipsum dolor sit amet. consectetuer adipiscing elit.
                    </td>
                    <td align="center">{{ $FactNonEssentialPurchasingOrder->quantity }}</td>
                    <td align="center">{{ number_format($FactNonEssentialPurchasingOrder->price_per_unit,2) }}</td>
                    <td align="center">{{ number_format($FactNonEssentialPurchasingOrder->discount_per_unit,2) }}</td>
                </tr>
                @php ($i++)
                @endforeach
            </tbody>
        </table>

        <table class="table table-nobordered" style="margin-top: 20px">
            <tr>
                <td style="width: 50%">
                    <div class="remark">
                        <p class="head">REMARK:</p>
                        <p>{{$NonEssentialPurchasingOrders->remark }}</p>
                    </div>
                </td>
                <td align="right">
                    <table align="right" class="table-summary">
                        <tr>
                            <td class="text-uppercase" align="right"><strong class="text-black">TOTAL</strong></td>
                            <td style="width: width: 200px;" align="right">{{ number_format($NonEssentialPurchasingOrders->amount ,2) }} <strong class="text-black">&nbsp;USD</strong></td>
                        </tr>
                        <tr>
                            <td class="text-uppercase" align="right"><strong class="text-black">DISCOUNT</strong></td>
                            <td align="right">{{ number_format($NonEssentialPurchasingOrders->discount ,2) }} <strong class="text-black">&nbsp;USD</strong></td>
                        </tr>
                        <tr>
                            <td class="text-uppercase" align="right"><strong class="text-black">TOTAL BEFORE VAT</strong></td>
                            <td align="right">{{ number_format($NonEssentialPurchasingOrders->amount_before_vat ,2) }} <strong class="text-black">&nbsp;USD</strong></td>
                        </tr>
                        <tr>
                            <td class="text-uppercase" align="right"><strong class="text-black">VAT</strong></td>
                            <td align="right">{{ number_format($NonEssentialPurchasingOrders->vat ,2) }} <strong class="text-black">&nbsp;USD</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                        </tr>
                        <tr class="text-black">
                            <td style="width: 50%;" class="text-uppercase" align="right"><strong class="summary">TOTAL</strong></td>
                            <td align="right"><strong class="summary">{{ number_format($NonEssentialPurchasingOrders->grand_total ,2) }}</strong> <strong>USD</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table class="table table-nobordered">
            <tr>
                <td style="width: 50%">
                    <table class="signature">
                        <tr>
                            <td style="width: 60px;" rowspan="2" valign="top">
                                <strong class="text-uppercase">Signed : </strong>
                            </td>
                            <td>
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><p style="padding-top: 10px;">(LOREM IPSUM)</p></td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <table class="signature">
                        <tr>
                            <td style="width: 80px;" rowspan="2" valign="top">
                                <strong class="text-uppercase">Approver : </strong>
                            </td>
                            <td>
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><p style="padding-top: 10px;">(LOREM IPSUM)</p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>
</div>
</div>
<div class="x_content modalBox">
<div class="content scroll-2">
    <div>
        <h4><span class="btn-label"><i class="fa fa-file-text info" aria-hidden="true"></i></span> Log</h4>
        <p>
            <table class="table logList">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>USER</th>
                        <th>CHANNEL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>02/09/2017</td>
                        <td>A</td>
                        <td>App</td>
                        <td>New</td>
                    </tr>
                    <tr>
                        <td>01/09/2017</td>
                        <td>B</td>
                        <td>App</td>
                        <td>Approved</td>
                    </tr>
                    <tr>
                        <td>29/08/2017</td>
                        <td>C</td>
                        <td>App</td>
                        <td>UnApproved</td>
                    </tr>
                    <tr>
                        <td>28/08/2017</td>
                        <td>D</td>
                        <td>App</td>
                        <td>Approve</td>
                    </tr>
                    <tr>
                        <td>27/08/2017</td>
                        <td>E</td>
                        <td>App</td>
                        <td>Delete</td>
                    </tr>
                </tbody>
            </table>
        </p>
        <p align="center">
            <button type="button" class="btn btn-ngin btn-default" id="closeLogBtn">
                <span class="btn-label"><i class="fa fa-thumbs-o-up success" aria-hidden="true"></i></span> OK
            </button>
        </p>
    </div>
</div>
</div>
@endsection

@section('right-sidebar')
<div class="showCtrl" align="center">
    <p>
        <button type="button" class="btn btn-ngin btn-default log" id="showLogBtn">
            <span class="btn-label"><i class="fa fa-file-text-o info" aria-hidden="true"></i></span>Log
        </button>
    </p>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p>
        <button type="button" class="btn btn-ngin btn-default send">
            <span class="btn-label"><i class="fa fa-envelope info" aria-hidden="true"></i></span>Send Email
        </button>
    </p>
    <p>
        <button type="button" class="btn btn-ngin btn-default print">
            <span class="btn-label"><i class="fa fa-print info" aria-hidden="true"></i></span>Print
        </button>
    </p>
    <br>
    <p>

    <form id="update-form" method="post" >
        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" name="is_approve" id="is_approve" value="NULL">
        {!! csrf_field() !!}
                   
    </form>

    <form id="delete-form" method="post" >
        <input name="_method" type="hidden" value="DELETE">
        {!! csrf_field() !!}
                   
    </form>
        <table>
            <tr>
                <td align="right"><strong class="text-uppercase">Approved : </strong></td>
                <td>{{$NonEssentialPurchasingOrders->approval_user_id}}</td>
            </tr>
            <tr>
                <td align="right"><strong class="text-uppercase">Approved Date : </strong></td>
                <td>************</td>
            </tr>
            <tr>
                <td align="right"><strong class="text-uppercase">Approved Time : </strong></td>
                <td>***********</td>
            </tr>
        </table>
    </p>
    <p>
        <button type="button" class="btn btn-ngin btn-danger actionBtn" data-action="{{ route('backOffice.purchasing.non-essential-purchasing-order.patch-status', $NonEssentialPurchasingOrders->id) }}" data-status="unapprove"  style="background: #fd0000 !important">
            UnApprove <i class="fa fa-times-circle-o" aria-hidden="true"></i></span>
        </button>
    </p>
    <p>
        <button type="button" class="btn btn-ngin btn-default btn-delete actionBtn">
            Cancel Document <i class="fa fa-exclamation info-circle" aria-hidden="true" style="color: #38393a; background: #fff; border-radius: 50px; padding: 2px 4px 0px; font-size: 11px;"></i></span>
        </button>
    </p>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/back-office/purchasing-order/show.js') }}"></script>
    <script type="text/javascript">
        

        $('.btn-danger').click(function(event) {
            var status = $("#is_approve");
            console.log(status);
             status[0].value = ($(this).data('status'));
             $("#update-form").attr('action',$(this).data('action')).submit();
        });

        $('.btn-delete').click(function(event) {
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
    </script>
@endsection
