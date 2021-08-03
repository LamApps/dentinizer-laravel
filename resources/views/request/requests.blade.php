@extends('layouts/layoutMaster')

@section('title', 'Supply Request System')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/plugins/forms/form-validation.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">

<link href="{{ asset('new-assets/js/select2/select2.min.css') }}" rel="stylesheet" />
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
                <h4 class="card-title">{{ __('locale.requests') }}</h4>
                <div class="row mb-2">
                    <div class="col-md-10" id="SYNC_LOADER">

                    </div>
                    <div class="col-md-2 text-right">
                        <button onclick="_formRequest(0)"
                            class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
                        <button onclick="_syncOdooProducts()" title="Get products from odoo"
                            class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD_CLOUD')!!}</button>
                    </div>
                </div>
                <!-- Notes -->
                <div class="table-responsive">
                    <table id="requests_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.number') }}</th>
                                <th>{{ __('locale.to') }}</th>
                                <th>{{ __('locale.subject') }}</th>
                                <th>{{ __('locale.status') }}</th>
                                <th>{{ __('locale.sent_at') }}</th>
                                <th>{{ __('locale.created_at') }}</th>
                                <th>{{ __('locale.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- Notes -->
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal_form_request" formName="REQUEST" content="modal_form_request_body" />
@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('new-assets/js/select2/select2.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
/* Requests */
var dtUrl = '/admin/sdt/requests';
var requests_datatable = $('#requests_datatable');
requests_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
    @endif
    processing: true,
    paging: true,
    ordering: false,
    ajax: {
        url: dtUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
});
var _reload_requests_datatable = function() {
    $('#requests_datatable').DataTable().ajax.reload();
}

function _formRequest(id) {
    var modal_id = "modal_form_request";
    var modal_content_id = "modal_form_request_body";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (id > 0) ? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#REQUEST_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/admin/form/request/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

function _viewRequest(id) {
    var modal_id = "modal_form_request";
    var modal_content_id = "modal_form_request_body";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    $("#REQUEST_MODAL_TITLE").html("{{__('locale.details_request_n')}} : #REQUEST-"+id);
    $.ajax({
        url: "/admin/view/request/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_REQUEST").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_REQUEST").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/request",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_request").modal("hide");
                    //var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
                    //_formInvoice(patient_id, result.invoice_id);
                } else {
                    _showResponseMessage("error", result.msg);
                }
            },
            error: function(error) {
                _showResponseMessage(
                    "error",
                    "Oooops..."
                );
            },
            complete: function(resultat, statut) {
                $("#SPAN_SAVE_REQUEST").removeClass("spinner-border spinner-border-sm");
                _reload_requests_datatable();
                //_loadBillingStats();
            },
        });
        return false;
    },
});

function _syncOdooProducts(){
    var spinner ='<center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Sync...</span></div></center>';
    $("#SYNC_LOADER").html(spinner);
    $.ajax({
        url: "/api-odoo/sync-products.php",
        type: "GET",
        dataType: "JSON",
        success: function(result, status) {
            if (result.success) {
                    _showResponseMessage("success", result.msg);
            } else {
                    _showResponseMessage("error", result.msg);
            }
            $("#SYNC_LOADER").html('');
        },
    });
}

function _deleteRequest(id) {
    var successMsg = "Successfully deleted backup!";
    var errorMsg = "Request has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete this request?";
    var swalConfirmText = "You can't go back!";
    Swal.fire({
        title: swalConfirmTitle,
        text: swalConfirmText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-outline-danger ml-1",
        },
        buttonsStyling: false,
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: "/admin/request/delete/" + id,
                type: "DELETE",
                cache: false,
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                dataType: "JSON",
                success: function(result, status) {
                    if (result.success) {
                        _showResponseMessage("success", successMsg);
                    } else {
                        _showResponseMessage("error", errorMsg);
                    }
                },
                error: function(result, status, error) {
                    _showResponseMessage("error", errorMsg);
                },
                complete: function(result, status) {
                    _reload_requests_datatable();
                },
            });
        }
    });
}
</script>
@endsection