@extends('layouts/layoutMaster')

@section('title', 'Patient profile')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">

<link href="{{ asset('new-assets/js/select2/select2.min.css') }}" rel="stylesheet" />

<link href="{{ asset('new-assets/js/fancybox/jquery.fancybox.min.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/js/jcarousel/custom_jcarousel.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

@php
$birthday = $age='';
if($patient_data[0]){
    if(isset($patient_data[0]->birthday)){
        $dt = Carbon\Carbon::createFromFormat('Y-m-d',$patient_data[0]->birthday);
        $birthday = $dt->format('d/m/Y');
        $age=\Carbon\Carbon::parse($dt)->diff(\Carbon\Carbon::now())->format('%y years');
    }
}
@endphp

<input type="hidden" id="INPUT_HIDDEN_PATIENT_ID" value="{{ $patient_data[0]->id }}" />

<div class="row">
    <div class="col-md-12">
        <!-- Overview -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-start align-items-center mb-1">
                    <div class="avatar mr-1">
                        <div class="avatar bg-light-primary avatar-lg">
                            <span class="avatar-content">{{ $short_name }}</span>
                        </div>
                    </div>

                    <div class="profile-user-info">
                        <h5 class="mb-0">{{ $patient_data[0]->ar_name }}</h5>
                        <h5 class="mb-0">{{ $patient_data[0]->name }}</h5>
                        <small class="text-muted"><b>{{ __('locale.gender') }}</b> : {{ $patient_data[0]->gender }} - <b>{{ __('locale.age') }} : </b> {{ $age }}</small>
                    </div>
                </div>
                @if($medical_conditions)<p class="text-danger">Medical conditions : {{$medical_conditions}}</p>@endif
            </div>
        </div>
        <!-- Overview -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" id="VIEW_INPUT_PATIENT_ID_HELPER" value="{{ $patient_data[0]->id }}">
                <!-- DETAILS -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview"
                            onclick="_loadContent('overview')" aria-controls="overview" role="tab"
                            aria-selected="true"><i data-feather="credit-card"></i>
                            {{ __('locale.overview') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="procedures-tab" data-toggle="tab" href="#procedures"
                            onclick="_loadContent('procedures')" aria-controls="home" role="tab" aria-selected="true"><i
                                data-feather="grid"></i>
                                {{ __('locale.procedures') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes"
                            onclick="_loadContent('notes')" aria-controls="profile" role="tab" aria-selected="false"><i
                                data-feather="mic"></i>
                                {{ __('locale.notes') }}</a>
                    </li>
                    @if(in_array(auth()->user()->user_type,['admin','doctor','reception']))
                    <li class="nav-item">
                        <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billings" aria-controls="about"
                            onclick="_loadContent('billings')" role="tab" aria-selected="false"><i
                                data-feather="file-text"></i> {{ __('locale.billing') }}</a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" id="storageIcon-tab" data-toggle="tab" href="#storages"
                            onclick="_loadContent('storages')" aria-controls="storage" role="tab"
                            aria-selected="false"><i data-feather="archive"></i>
                            {{ __('locale.storage') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="storageIcon-tab" data-toggle="tab" href="#xray"
                            onclick="_loadContent('xray')" aria-controls="xray" role="tab"
                            aria-selected="false"><i data-feather="activity"></i>
                            {{ __('locale.xray') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" aria-labelledby="overview-tab" role="tabpanel"></div>
                    <div class="tab-pane" id="procedures" aria-labelledby="procedures-tab" role="tabpanel"></div>
                    <div class="tab-pane" id="notes" aria-labelledby="notes-tab" role="tabpanel"></div>
                    <div class="tab-pane" id="billings" aria-labelledby="billing-tab" role="tabpanel"></div>
                    <div class="tab-pane" id="storages" aria-labelledby="storageIcon-tab" role="tabpanel"></div>
                    <div class="tab-pane" id="xray" aria-labelledby="xrayIcon-tab" role="tabpanel"></div>
                </div>
            </div>
            <!-- DETAILS -->
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_note">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="NOTE_MODAL_TITLE">Modal title</h5>
                <button type="button" onclick="_reset_note_form()" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_NOTE" enctype="multipart/form-data">
                    <div id='modal_form_note_body'>
                    </div>
                </form>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button onclick="_submit_note_form()" class="btn btn-primary"><i data-feather="save"></i> {{ __('locale.save') }}
                    <span id="SPAN_SAVE"></span> </button>
                <button onclick="_reset_note_form()" data-dismiss="modal" class="btn btn-danger"><i
                        data-feather="x"></i> {{ __('locale.cancel') }}</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_storage">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="STORAGE_MODAL_TITLE">Add file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <!-- <form id="FORM_STORAGE" action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data"> -->
                <form id="FORM_STORAGE" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="patient_id" name="patient_id" value="{{$patient_id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="birth-day">Title</label>
                                <input class="form-control form-control-sm" id="title" name="title" type="text"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="cf-default-textarea">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" cols="30" rows="5" id="description"
                                        name="description" placeholder="Write your description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- WEBCAM JS -->
                        <div class="col-md-12">

                            <button type="button" onclick="show_upload_file();" class="btn btn-outline-primary"><i
                                    data-feather="upload"></i>&nbsp;Upload file</button>
                            <button type="button" onclick="setup_camera(); $(this).hide().next().show();"
                                class="btn btn-outline-primary"><i data-feather="camera"></i>&nbsp;Access
                                Camera</button>
                            <button type="button" onclick="take_photo()" class="btn btn-outline-primary"
                                style="display:none"><i data-feather="camera"></i> Take photos</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" id="data_uri_hidden">
                                <div id="BLOCK_CAMERA"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="card" id="results"></div>
                            </div>
                        </div>
                        <!-- WEBCAM JS -->
                        <!-- INPUT FILE -->
                        <div class="col-md-12">
                            <div class="form-group" id="BLOCK_UPLOAD_FILE">
                                <!-- <input type="file" class="form-control-file" name="file" id="file" required /> -->
                            </div>
                        </div>
                        <!-- INPUT FILE -->

                    </div>
                </form>


            </div><!-- .modal-body -->

            <div class="modal-footer">
                <button onclick="$('#FORM_STORAGE').submit()" class="btn btn-primary"><i
                        data-feather="save"></i>{{ __('locale.save') }}
                    <span id="SPAN_SAVE_STORAGE"></span> </button>
                <button data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>{{ __('locale.cancel') }}</button>
            </div>

        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<x-modal-form id="modal_form_procedure_service_item" formName="ITEM"
    content="modal_form_procedure_service_item_content" />
<x-modal-form id="modal_form_invoice" formName="INVOICE" content="modal_form_invoice_content" />
<x-modal-form id="modal_add_items_to_invoice" formName="INVOICE_ITEMS" content="modal_add_items_to_invoice_content" />
<x-modal-form id="modal_form_payment" formName="PAYMENT" content="modal_form_payment_content" />
<x-modal-form id="modal_form_refund" formName="REFUND" content="modal_form_refund_content" />
<x-modal-form id="modal_form_quick_invoice" formName="QUICK_INVOICE" content="modal_form_quick_invoice_content" />


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_xray">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="XRAY_MODAL_TITLE">{{ __('locale.add_xray') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="FORM_XRAY" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="patient_id" name="patient_id" value="{{$patient_id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="birth-day">Title</label>
                                <input class="form-control form-control-sm" id="title" name="title" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="cf-default-textarea">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-sm" cols="30" rows="5" id="description"
                                        name="description" placeholder="Write your description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="file" id="file" required />
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->

            <div class="modal-footer">
                <button onclick="$('#FORM_XRAY').submit()" class="btn btn-primary"><i
                        data-feather="save"></i>{{ __('locale.save') }}
                    <span id="SPAN_SAVE_XRAY"></span> </button>
                <button data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>{{ __('locale.cancel') }}</button>
            </div>

        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<!-- responsive -->
<!-- <script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script> -->

<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('new-assets/js/recorder.js') }}"></script>


<script src="{{ asset('new-assets/js/select2/select2.min.js') }}"></script>

<script src="{{ asset('new-assets/js/fancybox/jquery.fancybox.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('new-assets/js/webcam/webcam.min.js') }}"></script>

<script src="{{ asset('new-assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>

<script src="{{ asset('new-assets/js/jcarousel/jcarousel.min.js') }}"></script>
@endsection
@section('page-script')
<!-- <script src="{{ asset('new-assets/js/recorder-script.js') }}"></script> -->
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//
function _loadContent(viewtype) {
    var patient_id = $('#VIEW_INPUT_PATIENT_ID_HELPER').val();
    var spinner =
        '<center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center>';
    $('#' + viewtype).html(spinner);
    _resetContent(viewtype);
    $.ajax({
        url: '/profile/construct/' + viewtype + '/' + patient_id,
        type: 'GET',
        dataType: 'html',
        success: function(html, status) {
            $('#' + viewtype).html(html);
        },
        complete: function(result, status) {}
    });
}

function _resetContent(viewtype) {
    if (viewtype == 'overview') {
        $('#procedures,#notes,#billings,#storages,#xray').html('');
    }
    if (viewtype == 'procedures') {
        $('#overview,#notes,#billings,#storages,#xray').html('');
    }
    if (viewtype == 'notes') {
        $('#procedures,#overview,#billings,#storages,#xray').html('');
    }
    if (viewtype == 'billings') {
        $('#procedures,#notes,#overview,#storages,#xray').html('');
    }
    if (viewtype == 'storages') {
        $('#procedures,#notes,#billings,#overview,#xray').html('');
    }
    if (viewtype == 'xray') {
        $('#procedures,#notes,#billings,#overview,#storages').html('');
    }

}
_loadContent('overview');
</script>
@endsection