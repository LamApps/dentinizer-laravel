@php
$app_title=config('global.app_title');
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Procedures - {{$app_title}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <style type="text/css">
    body {
        color: #6e6b7b !important;
        font-size: 14px !important;
        font-family: 'Montserrat' !important;
    }

    .mb-2 {
        margin-bottom: 20px !important;
    }

    table {
        font-size: 14px !important;
    }

    .gray {
        background-color: #ebebeb;
    }

    hr {
        border-top: 1px solid #ebe9f1 !important;
        overflow: visible !important;
    }

    table tr td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
        padding: 4px !important;
    }
    </style>

</head>

<body>
    <table style="width:100%;border: 1px solid black;border-collapse: collapse;">
        <thead>
            <tr class="gray">
                <td colspan="7" style="text-align:center;font-size: 15px;" class="gray">Procedures</td>
            </tr>
            <tr class="gray">
                <td colspan="3">Doctor : <strong>{{$doctor->name}}</strong></td>
                <td colspan="2">Patient : <strong>{{($patient->ar_name)?$patient->ar_name:$patient->name}}</strong></td>
                <td colspan="2">Date : {{$today->format('Y-m-d')}}</td>
            </tr>
            <tr class="gray">
                <th>Teeth</th>
                <th>Service</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Cost</th>
                <th>Total</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @if(count($procedure_service_items))
            @foreach($procedure_service_items as $item)
            <tr>
                <td style="height:70px;" align="center">{{$item->teeth_id}}</td>
                <td align="center">{{$item->service->service_name}} ({{$item->service->code}})</td>
                <td align="center">{{$item->type}}</td>
                <td align="right">{{$item->quantity}}</td>
                <td align="right">{{$item->rate}} {{env('CURRENCY_SYMBOL')}}</td>
                <td align="right">{{$item->total}} {{env('CURRENCY_SYMBOL')}}</td>
                <td align="center">{{$item->note}}</td>
            </tr>
            @endforeach
            @endif

            @if($nb_empty_rows>0)
                @for ($i = 1; $i <= $nb_empty_rows; $i++) 
                <tr>
                    <td style="height:70px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            @endif

        </tbody>
        <!-- <tfoot>
            <tr>
                <td colspan="7">Signature : </td>
            </tr>
        </tfoot> -->
    </table>


    <footer>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="left" style="border: 0px;">
                        <p>Patient signature</p>
                    </td>
                    <td align="left" style="border: 0px;">
                        <p></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </footer>
</body>

</html>