@extends('pdf.container')
@section('content')
<div class="card card-body p-5">
    <div class="row">
        <div class="col text-right">            
        </div>
    </div>

    <div class="row">
        <div class="col text-center">

            <!-- Title -->
            <h2 class="mb-2">
               Invoice Code
            </h2>

            <!-- Text -->
            <p class="text-muted mb-4">
                <strong class="text-body">{{$showInvoice->code}}</strong> <br>
            </p>

        </div>
    </div> 
    
    <div class="row">
        <div class="col-12 col-md-12">
             <!-- Title -->
            <h6 class="text-uppercase text-muted">
                Invoiced From
            </h6>

            <!-- Text -->
            <p class="text-muted mb-4">
                <strong class="text-body">{{$doctorinfo->name}}</strong> <br>
            </p>
        </div>
        <div class="col-12 col-md-12 text-md-left">

            <!-- Heading -->
            <h6 class="text-uppercase text-muted">
               Invoiced To
            </h6>

            <!-- Text -->
            <p class="text-muted mb-4">
                <strong class="text-body">{{$patientinfo->name}}</strong> <br>
            </p>

            <!-- Heading -->
            <h6 class="text-uppercase text-muted">
                Invoice Date
            </h6>

            <!-- Text -->
            <p class="mb-4">
                <time>{{$showInvoice->created_at}}</time>
            </p>

        </div>
    </div> 
    
    <div class="row">
        <div class="col-12">

            <!-- Table -->
            <div class="table-responsive">
                <table class="table my-4">
                    <thead>
                        <tr>
                            <th class="px-0 bg-transparent border-top-0">
                                <span class="h6">Teeth id</span>
                            </th>
                            <th class="px-0 bg-transparent border-top-0">
                                <span class="h6">Service Name</span>
                            </th>
                            <th class="px-0 bg-transparent border-top-0">
                                <span class="h6">Total</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Invoicedetails as $Invoice)
                            <tr>
                                <td class="px-0">
                                    {{$Invoice->teeth_id}}
                                </td>
                                <td class="px-0">
                                    {{$Invoice->service}}
                                </td>
                                <td class="px-0">
                                     {{$Invoice->amount}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td><td></td>
                            <td class="px-0 pull-right">
                                    {{$showInvoice->total}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="hr"></div>
        </div>
    </div> 
</div>
@endsection
