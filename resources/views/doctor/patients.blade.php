@extends('layouts/layoutMaster')

@section('title', 'My patients')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.date.css') }}" />
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.patients') }}</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="limit_select">{{ __('locale.choose_limit_records_to_load') }} </label>
                            <select class="form-control form-control-sm" id="limit_select">
                                <option value="100" selected>100 {{ __('locale.records') }}</option>
                                <option value="200">200 {{ __('locale.records') }}</option>
                                <option value="500">500 {{ __('locale.records') }}</option>
                                <option value="1000">1000 {{ __('locale.records') }}</option>
                                <option value="0">{{ __('locale.all_records') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form id="formFilterSearch">
                            <label for="">{{ __('locale.search') }} :</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm"
                                    name="filter_text" placeholder="" aria-describedby="button-filter" />
                                <div class="input-group-append" id="button-filter">
                                    <button class="btn btn-outline-primary btn-sm" type="button" onclick='_submit_search_form();'><i data-feather="search"></i></button>
                                </div>
                            </div>
                            <div class="spinner-border text-primary d-none" id="SPINNER">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="col-md-8">
                        <button style="float:right;" type="button" onclick="_formPatient(0)"
                            class="btn btn-icon btn-sm btn-outline-primary"><i data-feather="plus"></i></button>
                    </div> -->
                </div>

                <div class="table-responsive">
                    <table id="patients_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.birthday') }}</th>
                                <th>{{ __('locale.address') }}</th>
                                <th>{{ __('locale.phone') }}</th>
                                <th>{{ __('locale.status') }}</th>
                                <th>{{ __('locale.appointments') }}</th>
                                <th>
                                {{ __('locale.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_appointment">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="APPONTMENT_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_APPOINTMENT">
                    <div id='modal_form_appointment_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i
                        data-feather="save"></i> Save <span id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/doctor/sdt/patients';
    var table = $('#patients_datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
        processing: true,
        paging: true,
        ordering: false,
        searching: false,
        ajax: {
            url: dtUrl,
            type: 'POST',
            data: function(d) {
                d.limit = $('#limit_select').val();
            }
        },
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 25,
        deferRender: true
    });
});
var _reload_patients_datatable = function() {
    $('#patients_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_patients_datatable();
});

function _formAppointment(id,patient_id) {
    var modal_id = "modal_form_appointment";
    var modal_content_id = "modal_form_appointment_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit appointment' : 'Add appointment';
    $("#APPONTMENT_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} ' + modalTitle);
    $.ajax({
        url: "/doctor/form/appointment/" + id+'/'+patient_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_APPOINTMENT").submit(function(event) {
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/doctor/form/appointment',
        success: function(response) {
            if (response.success) {
                $("#modal_form_appointment").modal('hide');
                _showResponseMessage("success", response.msg);
                
            } else {
                _showResponseMessage("error", response.msg);
            }
        },
        error: function() {}
    }).done(function(data) {
        $("#SPAN_SAVE_APPOINTMENT").removeClass("spinner-border spinner-border-sm");
        _reload_patients_datatable();
    });
    return false;
});

function _submit_form(){
    $("#SUBMIT_APPOINTMENT_FORM").click();
}
function _submit_search_form(){
    $("#formFilterSearch").submit();
}

$("#formFilterSearch").submit(function(event) {
    event.preventDefault();
    $("#SPINNER").removeClass('d-none');
    var formData = $(this).serializeArray();
    //ajax for datatable doctors
    var table = 'patients_datatable';
    var dtUrl = '/doctor/sdt/patients';
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: dtUrl,
        success: function(response) {
            if (response.data.length == 0) {
                $('#' + table).dataTable().fnClearTable();
                return 0;
            }
            $('#' + table).dataTable().fnClearTable();
            $("#" + table).dataTable().fnAddData(response.data, true);
        },
        error: function() {
            $('#' + table).dataTable().fnClearTable();
        }
    }).done(function(data) {
        $("#SPINNER").addClass('d-none');
    });
    return false;
});
</script>
@endsection