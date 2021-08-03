<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <!--[if mso]>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
    <style>
      td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
    </style>
  <![endif]-->
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700"
        rel="stylesheet" media="screen">
    <style>
    .hover-underline:hover {
        text-decoration: underline !important;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes ping {

        75%,
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    @keyframes pulse {
        50% {
            opacity: .5;
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(-25%);
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }

        50% {
            transform: none;
            animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
    }

    @media (max-width: 600px) {
        .sm-px-24 {
            padding-left: 24px !important;
            padding-right: 24px !important;
        }

        .sm-py-32 {
            padding-top: 32px !important;
            padding-bottom: 32px !important;
        }

        .sm-w-full {
            width: 100% !important;
        }
    }
    </style>
</head>
@php
$defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
$show_logo_in_signin_page=config('global.show_logo_in_signin_page');
$site_logo=config('global.site_logo');
$app_title=config('global.app_title');
$logo=$defaultLogos['logo'];
if(isset($site_logo) && !empty($site_logo)){
$logo=$site_logo;
}
@endphp

<body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased;">
    <div role="article" aria-roledescription="email" aria-label="" lang="en">
        <table style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; width: 100%;" width="100%"
            cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center"
                    style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;"
                    bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
                    <table class="sm-w-full" style="font-family: 'Montserrat',Arial,sans-serif; width: 600px;"
                        width="600" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td class="sm-py-32 sm-px-24"
                                style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; padding: 48px; text-align: center;"
                                align="center">
                                <a href="">
                                    <img src="{{asset($logo)}}" style="max-height:99px;" alt=""
                                        style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="sm-px-24" style="font-family: 'Montserrat',Arial,sans-serif;">
                                <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;" width="100%"
                                    cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="sm-px-24"
                                            style="--bg-opacity: 1; background-color: #ffffff; background-color: rgba(255, 255, 255, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));"
                                            bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                            <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Dear
                                                Sir/Madam</p>
                                            <p style="margin: 0 0 24px;">
                                                We would like to request for new medical supplies.Below details:
                                            </p>
                                            <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;"
                                                width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td
                                                        style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; padding: 16px;">
                                                        <table
                                                            style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;"
                                                            width="100%" cellpadding="0" cellspacing="0"
                                                            role="presentation">
                                                            <tr>
                                                                <td
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px;">
                                                                    <strong>Request number : </strong>
                                                                    #REQUEST-{{$request->id}}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;"
                                                width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td colspan="2" style="font-family: 'Montserrat',Arial,sans-serif;">
                                                        <table
                                                            style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;"
                                                            width="100%" cellpadding="0" cellspacing="0"
                                                            role="presentation">

                                                            <tr>
                                                                <th align="left" style="padding-bottom: 8px;">
                                                                    <p>Item</p>
                                                                </th>
                                                                <th align="left" style="padding-bottom: 8px;">
                                                                    <p>Description</p>
                                                                </th>
                                                                <th align="left" style="padding-bottom: 8px;">
                                                                    <p>Quantity</p>
                                                                </th>
                                                                <th align="right" style="padding-bottom: 8px;">
                                                                    <p>Rate</p>
                                                                </th>
                                                                <th align="right" style="padding-bottom: 8px;">
                                                                    <p>Total</p>
                                                                </th>
                                                            </tr>

                                                            @if(count($sprequestItems))
                                                            @foreach($sprequestItems as $item)
                                                            <tr>
                                                                <td
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; padding-top: 10px; padding-bottom: 10px;">
                                                                    {{$item->product_name}}
                                                                </td>
                                                                <td
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; padding-top: 10px; padding-bottom: 10px;">
                                                                    {{$item->description}}
                                                                </td>
                                                                <td
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; padding-top: 10px; padding-bottom: 10px;">
                                                                    {{$item->quantity}}
                                                                </td>
                                                                <td align="right"
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; text-align: right;">
                                                                    ${{number_format($item->rate,2)}}</td>
                                                                <td align="right"
                                                                    style="font-family: 'Montserrat',Arial,sans-serif; font-size: 14px; text-align: right;">
                                                                    ${{number_format($item->total,2)}}</td>
                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                            <tr>
                                                                <td style="font-family: 'Montserrat',Arial,sans-serif;"
                                                                    colspan="4">
                                                                    <p align="right"
                                                                        style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; padding-right: 16px; text-align: right;">
                                                                        Total
                                                                    </p>
                                                                </td>
                                                                <td style="font-family: 'Montserrat',Arial,sans-serif;">
                                                                    <p align="right"
                                                                        style="font-weight: 700; font-size: 14px; line-height: 24px; margin: 0; text-align: right;">
                                                                        ${{$total}}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            @if($request->message)
                                            <p
                                                style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                                                Message : <br>{{$request->message}}
                                            </p>
                                            @endif
                                            <p
                                                style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                                                If you have any questions about this request, simply reply to this email
                                                or call {{config('global.clinic_phone')}}.
                                            </p>
                                            <p
                                                style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                                                Best regards,
                                                <br>{{$app_title}} team
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Montserrat',Arial,sans-serif; height: 20px;" height="20"></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Montserrat',Arial,sans-serif; height: 16px;" height="16"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>