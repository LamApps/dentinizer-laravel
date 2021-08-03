@php
$layout='layoutMaster';
if($mode=='print')
    $layout='fullLayoutMaster';
@endphp
@extends('layouts/'.$layout)

@section('title', 'Invoice preview')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{asset('new-assets/app-assets/css/pages/app-invoice.css')}}">

@if($mode=='print')
<link rel="stylesheet" href="{{asset('new-assets/app-assets/css/pages/app-invoice-print.css')}}">
@endif

@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

@php
$dtBillDate = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->bill_date);
$dtIssueDate = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->due_date);
$percent = '';
if($invoice->discount_amount_type=='percentage'){
$percent = '('.$invoice->discount_amount.'%)';
}
@endphp
<section class="invoice-preview-wrapper">
    <div class="row invoice-preview invoice-print">
        <!-- Invoice -->
        <!-- <div class="col-xl-9 col-md-8 col-12"> -->
        <div class="col-md-{{($mode=='preview')?10:12}}">
            <div class="card invoice-preview-card">
                <div class="card-body invoice-padding pb-0">
                    <!-- Header starts -->
                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                        <div>
                            <div class="logo-wrapper">
                                <img style="max-height:60px" src="{{asset('new-assets/logo/logo_vertical.jpeg')}}"
                                    alt="">
                            </div>
                            <p class="card-text mb-25">DENTINIZER</p>
                        </div>
                        <div class="mt-md-0 mt-2">
                            <h4 class="invoice-title">
                                Invoice
                                <span class="invoice-number">#{{$invoice->number}}</span>
                            </h4>
                            <div class="invoice-date-wrapper">
                                <p class="invoice-date-title">Date Issued:</p>
                                <p class="invoice-date">{{$dtIssueDate->format('Y-m-d')}}</p>
                            </div>
                            <div class="invoice-date-wrapper">
                                <p class="invoice-date-title">Bill Date:</p>
                                <p class="invoice-date">{{$dtBillDate->format('Y-m-d')}}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Header ends -->
                </div>

                <hr class="invoice-spacing" />

                <!-- Address and Contact starts -->
                <div class="card-body invoice-padding pt-0">
                    <div class="row invoice-spacing">
                        <div class="col-md-8 p-0">
                            <h6 class="mb-2">Invoice From:</h6>
                            <h6 class="mb-25">{{$invoice->user->name}}</h6>
                            <p class="card-text mb-25">{{$doctor->address}}</p>
                            <p class="card-text mb-25">{{$doctor->phone}}</p>
                            <p class="card-text mb-0">{{$invoice->user->email}}</p>
                        </div>
                        <div class="col-md-4 p-0">
                            <h6 class="mb-2">Invoice To:</h6>
                            <h6 class="mb-25">{{($invoice->patient->ar_name)?$invoice->patient->ar_name:$invoice->patient->name}}</h6>
                            <p class="card-text mb-25">{{$invoice->patient->address}}</p>
                            <p class="card-text mb-25">{{$invoice->patient->phone}}</p>
                            <p class="card-text mb-0">{{$invoice->patient->email}}</p>
                        </div>
                    </div>
                </div>
                <!-- Address and Contact ends -->

                <!-- Invoice Description starts -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="py-1">Teeth ID</th>
                                <th class="py-1">Service</th>
                                <th class="py-1">Qty</th>
                                <th class="py-1">Cost</th>
                                <th class="py-1">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($items)>0)
                            @foreach($items as $item)
                            <tr>
                                <td class="py-1">
                                    <span class="font-weight-bold">{{$item->teeth_id}}</span>
                                </td>
                                <td class="py-1">
                                    <p class="card-text font-weight-bold mb-25">{{$item->service->service_name}}</p>
                                    <p class="card-text text-nowrap">
                                        {{$item->note}}
                                    </p>
                                </td>
                                <td class="py-1">
                                    <span class="font-weight-bold">{{$item->quantity}}</span>
                                </td>
                                <td class="py-1">
                                    <span class="font-weight-bold">{{number_format($item->rate,2)}} {{env('CURRENCY_SYMBOL')}}</span>
                                </td>
                                <td class="py-1">
                                    <span class="font-weight-bold">{{number_format($item->total,2)}} {{env('CURRENCY_SYMBOL')}}</span>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>


                <div class="card-body invoice-padding pb-0">
                    <div class="row invoice-sales-total-wrapper">
                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                            @if(count($refunds)>0)
                            <h6 class="mb-2">Refunds</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Raison</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($refunds as $refund)
                                    @php
                                    $refund_date = Carbon\Carbon::createFromFormat('Y-m-d',$refund->refund_date);
                                    @endphp
                                    <tr>
                                        <td>{{$refund_date->format('Y-m-d')}}</td>
                                        <td>{{number_format($refund->amount,2)}} {{env('CURRENCY_SYMBOL')}}</td>
                                        <td>{{$refund->reason}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                            <div class="invoice-total-wrapper">
                                <div class="invoice-total-item">
                                    <p class="invoice-total-title">Subtotal:</p>
                                    <p class="invoice-total-amount">{{$calcul['subtotal']}} {{env('CURRENCY_SYMBOL')}}</p>
                                </div>
                                <div class="invoice-total-item">
                                    <p class="invoice-total-title">Discount {{$percent}}:</p>
                                    <p class="invoice-total-amount">{{$calcul['discount_amount']}} {{env('CURRENCY_SYMBOL')}}</p>
                                </div>
                                <div class="invoice-total-item">
                                    <p class="invoice-total-title">Tax ({{$invoice->tax_percentage}}%):</p>
                                    <p class="invoice-total-amount">{{$calcul['tax_amount']}} {{env('CURRENCY_SYMBOL')}}</p>
                                </div>
                                <hr class="my-50" />
                                <div class="invoice-total-item">
                                    <p class="invoice-total-title">Total:</p>
                                    <p class="invoice-total-amount">{{$calcul['total']}} {{env('CURRENCY_SYMBOL')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invoice Description ends -->

                <hr class="invoice-spacing" />

                <!-- Invoice Note starts -->
                <div class="card-body invoice-padding pt-0">
                    <div class="row">
                        <div class="col-12">
                            <span class="font-weight-bold">Note:</span>
                            <span>{{$invoice->note}}</span>
                        </div>
                    </div>
                </div>
                <!-- Invoice Note ends -->
            </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->
        @if($mode=='preview')
        <div class="col-md-2 invoice-actions mt-md-0 mt-2">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-outline-secondary btn-block btn-download-invoice mb-75" href="/profile/pdf/invoice/{{$invoice->id}}/download">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Download</a>
                    <a class="btn btn-outline-secondary btn-block mb-75" href="/profile/invoice/{{$invoice->id}}/print" target="_blank">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('PRINT')!!} Print
                    </a>
                </div>
            </div>
        </div>
        @endif
        <!-- /Invoice Actions -->
    </div>
</section>

@endsection

@section('vendor-script')

@endsection
@section('page-script')
@if($mode=='print')
<script>
window.print();
</script>
@endif
@endsection