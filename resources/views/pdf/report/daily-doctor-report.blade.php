@php
$app_title=config('global.app_title');
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daily doctor's report - {{$app_title}}</title>
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
                <td colspan="{{($doctor==null)?9:8}}" style="text-align:center;font-size: 15px;" class="gray">Daily doctor's report</td>
            </tr>
            @if($doctor!=null)
            <tr class="gray">
                <td colspan="4">Doctor name : <strong>{{$doctor->name}}</strong></td>
                <td>Assistant name : </td>
                <td colspan="3">Date : {{$today->format('Y-m-d')}}</td>
            </tr>
            @else
            <tr class="gray">
                <td colspan="6"></td>
                <td colspan="3">Date : </td>
            </tr>
            @endif
            <tr class="gray">
                <td><strong> N</strong></td>
                @if($doctor==null)
                <td><strong> Doctor</strong></td>
                @endif
                <td><strong>Patient</strong></td>
                <td><strong>New</strong></td>
                <td><strong>Usual</strong></td>
                <td><strong>Note</strong></td>
                <td><strong>Next APP</strong></td>
                <td><strong>Dr.signature</strong></td>
                <td><strong>Admin</strong></td>
            </tr>
        </thead>
        <tbody>
            @if(count($appointments))
            @foreach($appointments as $apt)
            <tr>
                <td style="height:70px;">{{$apt->patient->id}}</td>
                @if($doctor==null)
                <td style="height:70px;">{{$apt->userdoctor->name}}</td>
                @endif
                <td>{{$apt->patient->name}}</td>
                <td>{{($states_array[$apt->patient->id]=='new')?'X':''}}</td>
                <td>{{($states_array[$apt->patient->id]=='usual')?'X':''}}</td>
                <td>{{$apt->comments}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            @endif

            @if($nb_empty_rows>0)
            @for ($i = 1; $i <= $nb_empty_rows; $i++)
            <tr>
                @if($doctor==null)
                <td></td>
                @endif
                <td style="height:70px;"></td>
                <td></td>
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
        <tfoot>
            <tr>
                <td colspan="{{($doctor==null)?9:8}}">Assistant signature : </td>
            </tr>
        </tfoot>
    </table>

</body>

</html>