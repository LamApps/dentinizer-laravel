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
        background-color: #edf9fd !important;
        font-weight: bold;
        /* font-size: x-small; */
        font-size: 12px !important;
        border: 1px solid black;
    }

    tbody tr td {
        /* font-size: x-small; */
        font-size: 12px !important;
        border: 1px solid black;
    }

    tfoot tr td {
        font-weight: bold;
        /* font-size: x-small; */
        font-size: 12px !important;
        border: 1px solid black;
        background-color: #edf9fd !important;
    }

    .gray {
        background-color: #F3F2F7;
    }

    .bg {
        background-color: #3f596a;
    }

    .box-bill {
        font-size: 30px !important;
        background-color: #3f596a;
        color: #fff !important;
        text-align: center;
    }

    .input {
        background-color: #edf9fd;
        width: 280px;
        padding-top: 10px;
        padding-bottom: 10px;
        direction: rtl;
        height: 20px !important;
    }

    hr {
        border-top: 1px solid #ebe9f1 !important;
        overflow: visible !important;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 1cm;
        right: 1cm;
        height: 1.5cm;
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
            <td align="center">
                <strong style="background-color: #3f596a;color:#fff;width:20px;border-radius: 30px;">س.ت
                    1134101887</strong>
            </td>
            <td valign="top" align="center">
                <img src="{{asset('new-assets/logo/logo-clinic.png')}}" alt="" width="150" />
            </td>
            <td align="center">
                <p style="width:100%" class="box-bill" style="direction:ltr;text-align:center;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bill فاتورة
                </p>
                <p>الرقم الضريبي 310228068100003</p>
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td>
                <p><strong>NAME : </strong></p>
            </td>
            <td class="input" align="center">
                {{($invoice->patient->ar_name)?$invoice->patient->ar_name:$invoice->patient->name}}
            </td>
            <td align="right">
                <p> : <strong style="direction: rtl;">الإسم</strong></p>
            </td>
            <td>
                <p><strong>BILL NO :</strong></p>
            </td>
            <td class="input" align="center">#{{$invoice->number}}</td>
            <td align="right">
                <p> : <strong style="direction: rtl;">رقم الفاتورة</strong></p>
            </td>
        </tr>
        <tr>
            <td>
                <p><strong>FILE NO. : </strong></p>
            </td>
            <td class="input">
            </td>
            <td align="right">
                <p> : <strong style="direction: rtl;">رقم الملف</strong></p>
            </td>
            <td>
                <p><strong>TIME & DATE :</strong></p>
            </td>
            <td class="input" align="center">
                {{$dtBillDate->format('Y-m-d')}}
            </td>
            <td align="right">
                <p> : <strong style="direction: rtl;">التاريخ و الوقت</strong></p>
            </td>
        </tr>
        <tr>
            <td>
                <p><strong>CLINIC : </strong></p>
            </td>
            <td class="input">
            </td>
            <td align="right">
                <p> : <strong>العيادة</strong></p>
            </td>
            <td>
                <p><strong>DOCTOR :</strong></p>
            </td>
            <td class="input" align="center">
                {{$invoice->user->name}}
            </td>
            <td align="right">
                <p> : <strong>الطبيب</strong></p>
            </td>
        </tr>
    </table>

    <br>

    <table style="border: 1px solid black;border-collapse: collapse;" width="100%">
        <thead style="background-color: #edf9fd;">
            <tr>
                <th width="55px" height="30px" align="center">
                    <p>تسلسل</p>
                    <p>SR. NO.</p>
                </th>
                <th width="70px" align="center">
                    <p>رقم الخدمة</p>
                    <p>ITEM NO.</p>
                </th>
                <th align="center">
                    <p>الوصف</p>
                    <p>DESCRIPTION</p>
                </th>
                <th align="center" width="100px">
                    <p>الكمية</p>
                    <p>QTY.</p>
                </th>
                <th width="100px" align="center">
                    <p>الإجمالي</p>
                    <p>TOT. AMOUNT</p>
                </th>
                <th width="80px" align="center">
                    <p>نسبة الخصم</p>
                    <p>DISC. %</p>
                </th>
                <th width="80px" align="center">
                    <p>قيمة الخصم</p>
                    <p>DISC. AMT</p>
                </th>
                <th width="120px" align="center">
                    <p>الصافي</p>
                    <p>NET AMTOUNT</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @if(count($items)>0)
            @foreach($items as $k=>$item)
            @php
            $k++;
            @endphp
            <tr>
                <td align="center">{{$k}}</td>
                <td align="center">{{$item->teeth_id}}</td>
                <td>
                    <p>{{$item->service->service_name}}</p>
                    <p>{{$item->note}}</p>
                </td>
                <td align="center">{{$item->quantity}}</td>
                <td align="right">{{number_format($item->rate,2)}} {{env('CURRENCY_SYMBOL')}}</td>
                <td></td>
                <td></td>
                <td align="right">{{number_format($item->total,2)}} {{env('CURRENCY_SYMBOL')}}</td>
            </tr>
            @endforeach
            @endif


        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" align="center" height="30px">
                    <p>الخصم الإضافي</p>
                    <p>EXTRA DISC.</p>
                </td>
                <td></td>
                <td></td>
                <td colspan="2" align="center">
                    <p>المجموع</p>
                    <p>TOTAL</p>
                </td>
                <td colspan="2" align="right">
                    <p>Subtotal : {{$calcul['subtotal']}} {{env('CURRENCY_SYMBOL')}}</p>
                    @if($calcul['discount_amount']>0) <p>Discount {{$percent}} : {{$calcul['discount_amount']}} {{env('CURRENCY_SYMBOL')}}</p>@endif
                    @if($calcul['tax_amount']>0)<p>Tax ({{$invoice->tax_percentage}}%) : {{$calcul['tax_amount']}}
                        {{env('CURRENCY_SYMBOL')}}</p>@endif
                    <p>Total : {{$calcul['total']}} {{env('CURRENCY_SYMBOL')}}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" height="30px">
                    <p>طريقة الدفع</p>
                    <p>PAYMENT</p>
                </td>
                <td align="right">
                    <p>: نقدي</p>
                    <p>{{$calcul['total_paid']}} {{env('CURRENCY_SYMBOL')}} : Cash</p>
                </td>
                <td align="right">
                    <p>: شبكة</p>
                    <p>: SPAN</p>

                </td>
                <td colspan="2" align="center">
                    <p>المبلغ المتبقي</p>
                    <p>DUE AMOUNT</p>
                </td>
                <td colspan="2" align="right">
                    @php
                    $due_amount=$calcul['nnf_total']-$calcul['nnf_total_paid'];
                    //dd($due_amount);
                    @endphp
                    <p>{{number_format($due_amount,2)}} {{env('CURRENCY_SYMBOL')}}</p>
                </td>
            </tr>
        </tfoot>
    </table>

    <table style="border: 0.5px solid black;border-collapse: collapse;border-top:0px;" width="100%">
        <tfoot>
            <tr>
                <td align="right" height="30px">
                    <p>: تحمل المريض</p>
                </td>
                <td align="right">
                    <p>: تحمل الشركة</p>
                </td>
                <td align="right">
                    <p>: شركة التأمين</p>
                </td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table width="100%">
        <tbody>
            <tr>
                <td align="right" style="border: 0px;">
                    <p>..........................................: توقيع المراجع</p>
                </td>
                <td align="right" style="border: 0px;">
                    <p>..........................................: اسم الموضف</p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    @if(count($refunds)>0)
    <table width="100%" style="border: 1px solid black;border-collapse: collapse;">
        <thead>
            <tr>
                <th colspan="3">Refunds</th>
            </tr>
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
                <td align="center">{{number_format($refund->amount,2)}} {{env('CURRENCY_SYMBOL')}}</td>
                <td>{{$refund->reason}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <br>
    <table width="100%">
        <tbody>
            <tr>
                <td style="border:0;">
                    <p>Note: <br>{{$invoice->note}}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <footer>
        <hr>

        <table width="100%">
            <tbody>
                <tr>
                    <td align="left" style="border: 0px;">
                        <p><img src="{{asset('new-assets/icones/instagram.png')}}" alt="" width="16" /> <img
                                src="{{asset('new-assets/icones/snapchat.png')}}" alt="" width="16" /> Dr.toothclinic
                        </p>
                    </td>
                    <td align="left" style="border: 0px;">
                        <p><img src="{{asset('new-assets/icones/whatsapp.png')}}" alt="" width="16" /> 0500173596</p>
                    </td>
                    <td align="right" style="border: 0px;">
                        <p><img src="{{asset('new-assets/icones/home.png')}}" alt="" width="16" />البكيرية ـ طريق الملك
                            عبد العزيز</p>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="border: 0px;">
                        <p><img src="{{asset('new-assets/icones/twitter.png')}}" alt="" width="16" /> @drtoothclinic</p>
                    </td>
                    <td align="left" style="border: 0px;">
                        <p><img src="{{asset('new-assets/icones/phone-call.png')}}" alt="" width="16" /> 0163350251</p>
                    </td>
                    <td style="border: 0px;"></td>
                </tr>
            </tbody>
        </table>
    </footer>

</body>

</html>