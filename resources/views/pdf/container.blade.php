<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8" />
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <style>
        body {
            color: #12263f;
            font-family: 'tajawal';
            direction: rtl;
        }

        .badge-dark {
            color: #fff;
            background-color: #12263f;
        }

        img {
            max-width: 4.5rem;
        }

        .badge {
            width: 60px;
            display: inline-block;
            padding: .33em .5em;
            font-size: 76%;
            font-weight: 400;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .375rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .row {
            width: 100% !important;
            max-width: width: 100% !important;
        }

        .col-md-6 {
            display: inline-block;
            width: 50%;
            float: right;
        }

        .text-md-right {
            text-align: left !important;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1.5rem;
            color: #12263f;
        }

        .text-muted {
            color: #95aac9 !important;
        }

        .text-body {
            color: #12263f !important;
        }

        .table thead th {
            background-color: #f9fbfd;
            text-transform: uppercase;
            font-size: .8125rem;
            font-weight: 600;
            letter-spacing: .08em;
            color: #95aac9;
            border-bottom-width: 1px;

            padding: 1rem;
        }

        .small {
            font-size: .9375rem;
            font-weight: 400;
        }

        .table td,
        .table th {
            padding: 1rem;
            vertical-align: top;
            border-top: 1px solid #edf2f9;
        }

        .hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid #e3ebf6;
            background: #e3ebf6;
        }
        .col-9 {
            width: 65%;
        }
        .col-3 {
            width: 35%;
        }
        .customed-table-small td,
        .customed-table-small th {
            padding: 0.4rem 0 !important;
            border-top: none;
        }

        .customed-table-small th {
            width: 140px;
        }

        .price-show {
            width: 100%;
            height: 100%;
            background: #eee;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .price-content {
            text-align: center;
            vertical-align: middle;
        }

    </style>
</head>

<body>
    @yield('content')
</body>

</html>
