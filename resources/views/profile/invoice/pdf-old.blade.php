<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{$invoice->number}} - Dentinizer</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <style type="text/css">
    body {
        color: #6e6b7b !important;
        font-size: 12px !important;
        font-family: 'Montserrat' !important;
    }

    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: inherit;
        font-weight: 500;
        line-height: 1.2;
        color: #5e5873;
    }

    .mb-2 {
        margin-bottom: 20px !important;
    }


    table {
        /* font-size: x-small; */
        font-size: 12px !important;
    }

    thead tr th {
        background-color: #F3F2F7 !important;
        font-weight: bold;
        /* font-size: x-small; */
        font-size: 12px !important;
    }

    tbody tr td {
        /* font-size: x-small; */
        font-size: 12px !important;
    }

    tfoot tr td {
        font-weight: bold;
        /* font-size: x-small; */
        font-size: 12px !important;
    }

    .gray {
        background-color: #F3F2F7;
    }

    hr {
        border-top: 1px solid #ebe9f1 !important;
        overflow: visible !important;
    }
    </style>

</head>

<body>
    @php
    $dtBillDate = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->bill_date);
    $dtIssueDate = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->due_date);
    $percent = '';
    if($invoice->discount_amount_type=='percentage'){
    $percent = '('.$invoice->discount_amount.'%)';
    }
    @endphp
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('new-assets/logo/logo_vertical.jpeg')}}" alt="" width="150" />
            </td>
            <td align="right">
                <h4>
                    Invoice
                    <strong>#{{$invoice->number}}</strong>
                </h4>
                <p>Date Issued:
                    <strong>{{$dtIssueDate->format('Y-m-d')}}</strong>
                </p>
                <p>Bill Date:<strong>
                        {{$dtBillDate->format('Y-m-d')}}</strong></p>

            </td>
        </tr>
    </table>


    <hr />

    <table width="100%">
        <tr>
            <td>
                <p style="margin-bottom: 20px !important;">Invoice From:</p>
                <p><strong>{{$invoice->user->name}}</strong></p>
                <p>{{$doctor->address}}</p>
                <p>{{$doctor->phone}}</p>
                <p>{{$invoice->user->email}}</p>
            </td>
            <td align="right">
                <p>Invoice To:</p>
                <p><strong>{{($invoice->patient->ar_name)?$invoice->patient->ar_name:$invoice->patient->name}}</strong></p>
                <p>{{$invoice->patient->address}}</p>
                <p>{{$invoice->patient->phone}}</p>
                <p>{{$invoice->patient->email}}</p>
            </td>
        </tr>
    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>Teeth ID</th>
                <th>Service</th>
                <th>Qty</th>
                <th>Cost</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if(count($items)>0)
            @foreach($items as $item)
            <tr>
                <th>{{$item->teeth_id}}</th>
                <td>
                    <p><strong>{{$item->service->service_name}}</strong></p>
                    <p>
                        {{$item->note}}
                    </p>
                </td>
                <td align="right">{{$item->quantity}}</td>
                <td align="right">{{number_format($item->rate,2)}} $</td>
                <td align="right">{{number_format($item->total,2)}} $</td>
            </tr>
            @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Subtotal</td>
                <td align="right">{{$calcul['subtotal']}} $</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Discount {{$percent}}</td>
                <td align="right">{{$calcul['discount_amount']}} $</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Tax ({{$invoice->tax_percentage}}%)</td>
                <td align="right">{{$calcul['tax_amount']}} $</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td align="right">Total</td>
                <td align="right" class="gray">{{$calcul['total']}} $</td>
            </tr>
        </tfoot>
    </table>

    @if(count($refunds)>0)
    <p>Refunds</p>
    <table width="100%">
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
            $refund_date =
            Carbon\Carbon::createFromFormat('Y-m-d',$refund->refund_date);
            @endphp
            <tr>
                <td>{{$refund_date->format('Y-m-d')}}</td>
                <td align="center">{{number_format($refund->amount,2)}} $</td>
                <td>{{$refund->reason}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <hr class="invoice-spacing" />

    <p>Note:</p>
    <p>{{$invoice->note}}</p>

</body>

</html>