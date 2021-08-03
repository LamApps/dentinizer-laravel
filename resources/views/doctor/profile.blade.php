@extends('layouts/layoutMaster')

@section('title', 'Patient info')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Patient info</h4>

                <ul class="nav nav-tabs">

                    <li class="nav-item">
                        <a class="nav-link @if (!\Session::has('success_add_invoice') && !\Session::has('success_add_note') && !\Session::has('success_paid_invoice') && !\Session::has('success_add_storage')) active @endif"
                            data-toggle="tab" href="#tabOverview"><i
                                class="icon-event_note nav-icon"></i><span>Overview</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if (\Session::has('success_add_invoice')) active @endif" id="procedures"
                            data-toggle="tab" href="#tabProcedures"><i
                                class="icon-event_note nav-user"></i><span>Procedures</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(\Session::has('success_add_note')) active @endif" data-toggle="tab"
                            href="#tabNotes"><i class="icon-event_note nav-user"></i><span>Notes</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if (\Session::has('success_paid_invoice')) active @endif" data-toggle="tab"
                            href="#tabBilling"><i class="icon-event_note nav-user"></i><span>Billing</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if (\Session::has('success_add_storage')) active @endif" data-toggle="tab"
                            href="#tabStorage"><i class="icon-event_note nav-user"></i><span>Storage</span></a>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane @if(!\Session::has('success_add_invoice') && !\Session::has('success_add_note') &&  !\Session::has('success_paid_invoice') && !\Session::has('success_add_storage')) active @endif"
                        id="tabOverview">

                        <div class="row">
                            <div class="col-md-4">

                                <div class="d-flex flex-row bd-highlight mb-2">
                                    <div class="p-2 bd-highlight">
                                        <div class="avatar bg-light-primary avatar-lg">
                                            <span class="avatar-content">{{ $short_name }}</span>
                                        </div>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <p class="lead-text">{{ $patient_data[0]->name }}</p>
                                        <p class="sub-text">{{ $patient_data[0]->email }}</p>
                                    </div>
                                </div>

                                <h6 class="overline-title-alt">Birthday: <small>{{ $patient_data[0]->email }}</small></h6>
                                <h6 class="overline-title-alt">Phone: <small>{{ $patient_data[0]->phone }}</small></h6>
                                <h6 class="overline-title-alt">Address: <small>{{ $patient_data[0]->address }}</small></h6>

                            </div>
                            <div class="col-md-8">
                            <h4 class="nk-block-title mt-2">Personal Information</h4>
                            <p>Basic info, like your name and address, that you Nio Platform.</p>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane @if(\Session::has('success_add_invoice')) active @endif" id="tabProcedures">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">

                                <div class="d-flex flex-row bd-highlight links flex-center">
                                    @foreach($services as $service)
                                    <div class="p-2 bd-highlight"><a href="#" class="btn btn-outline-warning" style="border-radius: 15px; border-color: #ffc107 !important;">{{ $service->name }}</a></div>
                                    @endforeach
                                </div>
                                @if(count($services) == 0 )
                                <div class="links flex-center">
                                    <h5 class='text-success'>No services.</h5>
                                </div>
                                @endif
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(18)">
                                                    <img src="{{ asset('assets/tooth_images/18.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>18</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(17)">
                                                    <img src="{{ asset('assets/tooth_images/17.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>17</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(16)">
                                                    <img src="{{ asset('assets/tooth_images/16.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>16</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(15)">
                                                    <img src="{{ asset('assets/tooth_images/15.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>15</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(14)">
                                                    <img src="{{ asset('assets/tooth_images/14.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>14</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(13)">
                                                    <img src="{{ asset('assets/tooth_images/13.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>13</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(12)">
                                                    <img src="{{ asset('assets/tooth_images/12.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>12</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(11)">
                                                    <img src="{{ asset('assets/tooth_images/11.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>11</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(21)">
                                                    <img src="{{ asset('assets/tooth_images/11.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>21</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(22)">
                                                    <img src="{{ asset('assets/tooth_images/12.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>22</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(23)">
                                                    <img src="{{ asset('assets/tooth_images/13.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>23</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(24)">
                                                    <img src="{{ asset('assets/tooth_images/14.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>24</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(25)">
                                                    <img src="{{ asset('assets/tooth_images/15.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>25</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(26)">
                                                    <img src="{{ asset('assets/tooth_images/16.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>26</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(27)">
                                                    <img src="{{ asset('assets/tooth_images/17.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>27</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(28)">
                                                    <img src="{{ asset('assets/tooth_images/18.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>28</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(48)">
                                                    <p>48</p>
                                                    <img src="{{ asset('assets/tooth_images/48.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(47)">
                                                    <p>47</p>
                                                    <img src="{{ asset('assets/tooth_images/47.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(46)">
                                                    <p>46</p>
                                                    <img src="{{ asset('assets/tooth_images/46.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(45)">
                                                    <p>45</p>
                                                    <img src="{{ asset('assets/tooth_images/45.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(44)">
                                                    <p>44</p>
                                                    <img src="{{ asset('assets/tooth_images/44.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(43)">
                                                    <p>43</p>
                                                    <img src="{{ asset('assets/tooth_images/43.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(42)">
                                                    <p>42</p>
                                                    <img src="{{ asset('assets/tooth_images/42.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(41)">
                                                    <p>41</p>
                                                    <img src="{{ asset('assets/tooth_images/41.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item flip" onClick="openmodal(31)">
                                                    <p>31</p>
                                                    <img src="{{ asset('assets/tooth_images/41.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(32)">
                                                    <p>32</p>
                                                    <img src="{{ asset('assets/tooth_images/42.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(33)">
                                                    <p>33</p>
                                                    <img src="{{ asset('assets/tooth_images/43.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(34)">
                                                    <p>34</p>
                                                    <img src="{{ asset('assets/tooth_images/44.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(35)">
                                                    <p>35</p>
                                                    <img src="{{ asset('assets/tooth_images/45.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(36)">
                                                    <p>36</p>
                                                    <img src="{{ asset('assets/tooth_images/46.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(37)">
                                                    <p>37</p>
                                                    <img src="{{ asset('assets/tooth_images/47.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(38)">
                                                    <p>38</p>
                                                    <img src="{{ asset('assets/tooth_images/48.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="mytable" class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Teeth ID</th>
                                                        <th>Service Name</th>
                                                        <th>Note</th>
                                                        <th>Price</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_add_billing">
                                                    <form id="addbillingform"
                                                        action="{{ route('doctor.patient.BillingStore') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient_id }}">
                                                        @foreach($services as $service)
                                                        <tr>
                                                            <td><input type="hidden" name="teeth_id[]"
                                                                    value="{{ $service->teeth_id }}"><span>{{ $service->teeth_id }}</span>
                                                            </td>
                                                            <td><input type="hidden" name="service[]"
                                                                    value="{{ $service->name }}"><span>{{ $service->name }}</span>
                                                            </td>
                                                            <td><span>{{ $service->note }}</span></td>
                                                            <td><input type="hidden" name="amount[]"
                                                                    value="{{ $service->price }}"><span>{{ $service->price }}</span>
                                                            </td>
                                                            <td><span>{{ $service->type }}</span></td>
                                                        </tr>
                                                        @endforeach
                                                    </form>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane @if (\Session::has('success_add_storage')) active @endif" id="tabStorage">
                        

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <a href="#" id="new_service_btn" class="btn btn-icon btn-primary" data-toggle="modal"
                                                    data-target="#add_storage_modal"><i data-feather="plus"></i></a>
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($storages as $storage)
                                                    <tr>
                                                        <td><span>{{ $storage->title }}</span></td>
                                                        <td><span>{{ $storage->description }}</span></td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('storage.download', $storage->id) }}"
                                                                    class="btn btn-primary"><i
                                                                        class="icon-cloud"></i></a>
                                                                <button
                                                                    onclick="delete_func('delete_frm_{{ $storage->id }}')"
                                                                    type="button" class="btn btn-danger">
                                                                    <form
                                                                        action="{{ route('doctor.storage.destroy', ['storage_id' => $storage->id, 'patient_id' => $patient_id ])}}"
                                                                        name="delete_frm_{{ $storage->id }}"
                                                                        id="delete_frm_{{ $storage->id }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}
                                                                    </form>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane @if (\Session::has('success_add_note')) active @endif" id="tabNotes">
                        

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">

                                    <p>Notes</p>
                                    <div class="row mb-2">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2 text-right">
                                            <a href="#" id="new_modal_btn" class="btn btn-icon btn-primary" data-toggle="modal"
                                                data-target="#add_invoice_modal"><i data-feather="plus"></i>Add New Note</span></a>
                                        </div>
                                    </div>

                                        <div class="table-responsive">
                                            <table class="datatable table table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Note</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($notes as $note)
                                                    <tr>
                                                        <td><span>{{ $note->note }}</span></td>
                                                        <td>
                                                            <button onclick="delete_func('delete_note_{{ $note->id }}')"
                                                                type="button" class="btn btn-danger">
                                                                <form
                                                                    action="{{ route('doctor.note.destroy', ['id' => $note->id])}}"
                                                                    name="delete_note_{{ $note->id }}"
                                                                    id="delete_note_{{ $note->id }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}
                                                                </form>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane @if (\Session::has('success_paid_invoice')) active @endif" id="tabBilling">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <a style="float: right;color: #fff;"
                                                onclick="document.getElementById('addbillingform1').submit();"
                                                class="btn btn-icon btn-primary mb-1">
                                                <i data-feather="plus"></i>
                                            </a>
                                            <table id="mytable1" class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Teeth ID</th>
                                                        <th>Service Name</th>
                                                        <th>Note</th>
                                                        <th>Price</th>
                                                        <th>Type</th>
                                                        <th class="tb-tnx-action">
                                                            Action
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <form id="addbillingform1"
                                                        action="{{ route('doctor.patient.BillingStore') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="patient_id"
                                                            value="{{ $patient_id }}">
                                                        @foreach($services as $service)
                                                        <tr>
                                                            <td><input type="hidden" name="teeth_id[]"
                                                                    value="{{ $service->teeth_id }}"><span>{{ $service->teeth_id }}</span>
                                                            </td>
                                                            <td><input type="hidden" name="service[]"
                                                                    value="{{ $service->name }}"><span>{{ $service->name }}</span>
                                                            </td>
                                                            <td><span>{{ $service->note }}</span></td>
                                                            <td><input type="hidden" name="amount[]"
                                                                    value="{{ $service->price }}"><span>{{ $service->price }}</span>
                                                            </td>
                                                            <td><span>{{ $service->type }}</span></td>
                                                            <td class="text-center">
                                                                @if($service->type != "completed")
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button" data-toggle="modal"
                                                                        data-target="#view_notemodal"
                                                                        data-id="{{ json_encode($service) }}"
                                                                        class="btn btn-info">
                                                                        <i data-feather="edit"></i>
                                                                    </button>
                                                                </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($service->invoiced == 0)
                                                                <input type="checkbox" name="servic_ids[]"
                                                                    value="{{$service->id}}">
                                                                @else
                                                                <p>invoiced</p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </form>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($invoices as $invoice)
                                                    <?php 
                                                                $invoicedetails = DB::table('invoice_lists')->where('invoice_id',$invoice->id)->get(); 
                                                                $total += $invoice->amount;
                                                            ?>
                                                    <tr>
                                                        <td><span>{{ $invoice->code }}</span></td>
                                                        <td><span>{{ $invoice->d_email }}</span></td>
                                                        <td><span>{{ $invoice->p_email }}</span></td>
                                                        <td><span>{{ $invoice->amount }}</span></td>
                                                        <td>
                                                            @if($invoice->paid == 0)
                                                            <?php $dept += $invoice->amount; ?>
                                                            <form action="{{route('doctor.patient.BillingPaid')}}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="invoiceid"
                                                                    value="{{$invoice->id}}">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Paid</button>
                                                            </form>
                                                            @else
                                                            <?php $paid += $invoice->amount; ?>
                                                            <p>Paid</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{route('doctor.invoice.generatepdf',$invoice->id)}}"
                                                                    class="btn btn-info">
                                                                    PDF
                                                                </a>
                                                            </div>
                                                        </td>
                                                        {{--  <td>
                                                                    <a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#show_invoice_modal{{$invoice->id}}"><span
                                                            class="icon-eye"></span></a>
                                                        </td> --}}
                                                    </tr>
                                                    <tr>
                                                        <div class="modal" id="show_invoice_modal{{$invoice->id}}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Invoice Details</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <div class="row mt-2 mb-2">
                                                    <div class="col-md-4">
                                                        <h4> Total : {{$total}}</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4> Paid : {{$paid}}</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4> Residual : {{$dept}}</h4>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>


<!-- @@ Add Modal @e -->
<div class="modal fade bd-example-modal-lg" id="notemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body modal-body-lg">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row gy-4">
                            <input type="hidden" id="sel_category" value="0">
                            <div class="col-md-3">
                                <div id="context-menu-tree">
                                    <ul>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <input type="hidden" id="teeth_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cf-default-textarea">Note</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-sm" name="note" id="note"
                                                    cols="30" rows="6" placeholder="Enter Note"
                                                    required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Type</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control form-control-lg" id="type" name="type">
                                                    <option value="existing">existing</option>
                                                    <option value="planned">planned</option>
                                                    <option value="completed">completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li class="text-right">
                                                <a href="#" class="btn btn-lg btn-primary" id="note_save_btn">Save</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
<!-- .modal -->

<!-- @@ View Modal @e -->
<div class="modal fade bd-example-modal-lg" id="view_notemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body modal-body-lg">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row gy-4">
                            <input type="hidden" id="profile_id" value="0">
                            <input type="hidden" id="sel_category" value="0">
                            <div class="col-md-3">
                                <div id="context-menu-tree">
                                    <ul>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <input type="hidden" id="teeth_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cf-default-textarea">Note</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-sm" name="note" id="note"
                                                    cols="30" rows="6" placeholder="Enter Note"
                                                    required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Type</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control form-control-lg" id="e_type" name="e_type">
                                                    <option value="existing">existing</option>
                                                    <option value="planned">planned</option>
                                                    <option value="completed">completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li class="text-right">
                                        <a href="#" class="btn btn-lg btn-primary" id="note_save_btn">Save</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
<!-- .modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_storage_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('file.doctoreupload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="p_id" name="p_id" value="{{$patient_id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="birth-day">Title</label>
                                <input class="form-control form-control-sm" id="a_title" name="a_title" type="text"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="cf-default-textarea">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" cols="30" rows="5" id="a_description"
                                        name="a_description" placeholder="Write your description" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <input type="file" id="patientfile" name="file" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li class="text-right">
                                    <button type="submit" id="storage_save_btn"
                                        class="btn btn-lg btn-primary">Save</button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_invoice_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Add New Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('doctor.note.store')}}" method="post">
                @csrf
                <div class="modal-body">

                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Note</label>
                                <div class="form-control-wrap">
                                    <input type="hidden" name="user_id" id="user_id" value="{{$doctor_id}}">
                                    <input type="hidden" name="patient_id" id="patient_id" value="{{$patient_id}}">
                                    <textarea rows="5" class="form-control" name="note" id="note"
                                        placeholder="Type Your Note Here...."></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- .modal-body -->
                <div class="modal-footer">
                    <button class="btn btn-primary" id="note_save_btn"><span
                            class="icon-save"></span>&nbsp;Save</button>
                    <button data-dismiss="modal" class="btn btn-danger"><span
                            class="icon-close"></span>&nbsp;Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset('assets/js/libs/jstree.js?ver=2.3.0') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>

<script>
function openmodal(id) {
    clear();
    $("#notemodal").modal("show");
    $("#notemodal #modalTitle").text(id);
    $("#notemodal #teeth_id").val(id);
}

$("#notemodal  #context-menu-tree").jstree({
    "core": {
        "data": {!!$datas!!},
        "themes": {
            "responsive": false
        },
        "check_callback": true
    },
    "plugins": ["contextmenu"],
    "contextmenu": {
        "items": function($node) {

        }
    }
});


$("#notemodal  #context-menu-tree").bind("changed.jstree", function(e, data) {
    $("#notemodal  #sel_category").val(data.node.id);
    //alert("Checked: " + data.node.id);
    // alert("Parent: " + data.node.parent);    
});



$("#notemodal #note_save_btn").click(function(e) {
    e.preventDefault();
    var teeth_id = $("#notemodal #teeth_id").val();
    var notes = $("#notemodal #note").val();
    var category = $("#notemodal #sel_category").val();

    if (notes != "" && category != "0") {
        $.ajax({
            url: '{{route("doctor.patient.profilestore")}}',
            type: "POST",
            data: {
                patient_id: {{$patient_id}},
                category: category,
                teeth_id: teeth_id,
                notes: notes,
                type: $("#notemodal #type").val(),
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $("#notemodal").modal("hide");
                var tr = '<tr><td><input type="hidden" name="teeth_id[]" value="14"><span>' +
                    response['state']['teeth_id'] +
                    '</span></td><td><input type="hidden" name="service[]" value="BBB"><span>' +
                    response['state']['service'] + '</span></td><td><span>' + response['state'][
                        'note'
                    ] + '</span></td><td><input type="hidden" name="amount[]" value="' + response[
                        'state']['amount'] + '"><span>' + response['state']['amount'] +
                    '</span></td><td><span>' + response['state']['type'] + '</span></td></tr>';
                $('#mytable tbody').append(tr);

                var tr1 = '<tr><td><input type="hidden" name="teeth_id[]" value="14"><span>' +
                    response['state']['teeth_id'] +
                    '</span></td><td><input type="hidden" name="service[]" value="BBB"><span>' +
                    response['state']['service'] + '</span></td><td><span>' + response['state'][
                        'note'
                    ] + '</span></td><td><input type="hidden" name="amount[]" value="' + response[
                        'state']['amount'] + '"><span>' + response['state']['amount'] +
                    '</span></td><td><span>' + response['state']['type'] + '</span></td>' +
                    '<td class="text-center">@if(' + response["state"]["type"] +
                    ' != "completed")<div class="btn-group btn-group-sm"><button type="button" data-toggle="modal" data-target="#view_notemodal"  data-id="' +
                    JSON.stringify(response['state']) +
                    '"  class="btn btn-info"><i class="icon-edit1"></i></button></div>@endif</td><td>@if(' +
                    response["state"]["invoiced"] +
                    ' == 0)<input type="checkbox" name="servic_ids[]" value="' + response["state"][
                        "id"
                    ] + '" >@else<p>invoiced</p>@endif</td></tr>';
                $('#mytable1 tbody').append(tr1);

                if (response['state']['id'] >= 1) {
                    swal({
                        title: "Success!",
                        text: 'New note created successfully.',
                        icon: "success",
                    });
                } else if (response['state']['id'] < 1) {
                    swal({
                        title: "Waring!",
                        text: "Failed",
                        icon: "error",
                    });
                }
                clear();
                //location.reload();
            },
        });
    } else {
        swal({
            title: "Waring!",
            text: "Please select category and type note.",
            icon: "error",
        });
    }
});

function clear() {
    $("#notemodal #modalTitle").text("");
    $("#notemodal #teeth_id").val("");
    $("#notemodal #note").val("");
}

$('#view_notemodal').on('show.bs.modal', function(e) {

    var tmp = $('#view_notemodal #context-menu-tree').jstree(true);
    if (tmp) {
        tmp.destroy();
    }

    var service_data = $(e.relatedTarget).data('id');

    $("#view_notemodal #profile_id").val(service_data['id']);
    $("#view_notemodal #modalTitle").text(service_data['teeth_id']);
    $("#view_notemodal #teeth_id").val(service_data['teeth_id']);
    $("#view_notemodal #sel_category").val(service_data['category_id']);
    $("#view_notemodal #note").val(service_data['note']);

    $("#view_notemodal #e_type").val(service_data['type']);
    $('#select2-e_type-container').text(service_data['type']);

    var e_c_datas = {!!$datas!!};

    var state_child = {
        opened: true, // is the node open
        disabled: false, // is the node disabled
        selected: true // is the node selected
    };

    var state_parent = {
        opened: true, // is the node open
        disabled: false, // is the node disabled
        selected: false // is the node selected
    };

    for (var i = 0; i < e_c_datas.length; i++) {

        if (e_c_datas[i].id == service_data['category_id']) {
            e_c_datas[i].state = state_child;
        } else {
            e_c_datas[i].state = state_parent;
        }
    };


    $("#view_notemodal #context-menu-tree").jstree({
        "core": {
            "data": e_c_datas,
            "themes": {
                "responsive": false
            },
            "check_callback": true
        },
        "plugins": ["contextmenu"],
        "contextmenu": {
            "items": function($node) {

            }
        }
    });

    $("#view_notemodal  #context-menu-tree").bind("changed.jstree", function(e, data) {
        $("#view_notemodal  #sel_category").val(data.node.id);
        //alert("Checked: " + data.node.id);
        // alert("Parent: " + data.node.parent);    
    });

});

$("#view_notemodal #note_save_btn").click(function(e) {
    e.preventDefault();
    var teeth_id = $("#view_notemodal #teeth_id").val();
    var notes = $("#view_notemodal #note").val();
    var category = $("#view_notemodal #sel_category").val();

    if (notes != "" && category != "0") {
        $.ajax({
            url: '{{ route("doctor.patient.profilestore" )}}',
            type: "POST",
            data: {
                id: $("#view_notemodal #profile_id").val(),
                patient_id: {{$patient_id}},
                category: category,
                teeth_id: teeth_id,
                notes: notes,
                _token: "{{ csrf_token() }}",
                type: $("#view_notemodal #e_type").val(),
            },
            success: function(response) {
                $("#view_notemodal #notemodal").modal("hide");
                if (response['state']['id'] >= 1) {
                    swal({
                        title: "Success!",
                        text: 'New note created successfully000.',
                        icon: "success",
                    });
                } else if (response['state']['id'] < 1) {
                    swal({
                        title: "Waring!",
                        text: "Failed",
                        icon: "error",
                    });
                }

                clear();
                //location.reload();
            },
        });
    } else {
        swal({
            title: "Waring!",
            text: "Please select category and type note.",
            icon: "error",
        });
    }
});

$("#storage_save_btn").click(function(e) {
    var title = $("#a_title").val();
    var description = $("#a_description").val();
    var formData = new FormData(document.getElementById("patientfile"));
    $.ajax({
        url: '{{ route("file.doctoreupload.post" )}}',
        data: formData,
        type: "POST",
        data: {
            patient_id: {{$patient_id}},
            title: title,
            description: description,
            processData: false,
            contentType: false,
            _token: "{{ csrf_token() }}",
        },
        success: function(response) {
            $("#notemodal").modal("hide");
            if (response['state']['id'] >= 1) {
                swal({
                    title: "Success!",
                    text: 'New File Addes successfully.',
                    icon: "success",
                });
            } else if (response['state']['id'] < 1) {
                swal({
                    title: "Waring!",
                    text: "Failed",
                    icon: "error",
                });
            }
            clear();
            //location.reload();
        },
    });
});

function delete_func(val) {
    document.getElementById(val).submit();
}
</script>
@endsection