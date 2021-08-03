@extends('layouts/layoutMaster')

@section('title', 'Doctor Schedule Timings')

@section('vendor-style')
<!-- vendor css files -->
<!-- <link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
  <link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="{{ asset('new-assets/js/select2/select2.min.css') }}" rel="stylesheet" />

@endsection

@section('page-style')
{{-- Page Css files --}}
<!-- <link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}"> -->
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.schedule_timings') }}</h4>

                <div class="form-group">
                    <label for="select-doctos">{{ __('locale.choose_doctor') }}</label>
                    <select class="form-control js-select2" id="select-doctos">
                    </select>
                </div>

                <!-- frequently asked questions tabs pills -->
                <section id="faq-tabs">
                    <!-- vertical tab pill -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                <!-- pill tabs navigation -->
                                <ul class="nav nav-pills nav-left flex-column" role="tablist">
                                    <input type="hidden" id="CURRENT_DAY">
                                    <!-- monday -->
                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('MONDAY')" class="nav-link active" id="monday"
                                            data-toggle="pill" href="#CONTENT-MONDAY" aria-expanded="true" role="tab">
                                            <span class="font-weight-bold">{{ __('locale.MONDAY') }}</span>
                                        </a>
                                    </li>

                                    <!-- TUESDAY -->
                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('TUESDAY')" class="nav-link" id="TUESDAY"
                                            data-toggle="pill" href="#CONTENT-TUESDAY" aria-expanded="false" role="tab">
                                            <span class="font-weight-bold">{{ __('locale.TUESDAY') }}</span>
                                        </a>
                                    </li>

                                    <!-- cancellation and return -->
                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('WEDNESDAY')" class="nav-link" id="WEDNESDAY"
                                            data-toggle="pill" href="#CONTENT-WEDNESDAY" aria-expanded="false"
                                            role="tab">
                                            <span class="font-weight-bold">{{ __('locale.WEDNESDAY') }}</span>
                                        </a>
                                    </li>

                                    <!-- my order -->
                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('THURSDAY')" class="nav-link" id="THURSDAY"
                                            data-toggle="pill" href="#CONTENT-THURSDAY" aria-expanded="false"
                                            role="tab">
                                            <span class="font-weight-bold">{{ __('locale.THURSDAY') }}</span>
                                        </a>
                                    </li>

                                    <!-- product and services-->
                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('FRIDAY')" class="nav-link" id="FRIDAY"
                                            data-toggle="pill" href="#CONTENT-FRIDAY" aria-expanded="false" role="tab">
                                            <span class="font-weight-bold">{{ __('locale.FRIDAY') }}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('SATURDAY')" class="nav-link" id="SATURDAY"
                                            data-toggle="pill" href="#CONTENT-SATURDAY" aria-expanded="false" role="tab">
                                            <span class="font-weight-bold">{{ __('locale.SATURDAY') }}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="_loadSchedules('SUNDAY')" class="nav-link" id="SUNDAY"
                                            data-toggle="pill" href="#CONTENT-SUNDAY" aria-expanded="false" role="tab">
                                            <span class="font-weight-bold">{{ __('locale.SUNDAY') }}</span>
                                        </a>
                                    </li>


                                </ul>

                            </div>
                        </div>

                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <!-- pill tabs tab content -->
                            <div class="tab-content">
                                <!-- monday panel -->
                                <div role="tabpanel" class="tab-pane active" id="CONTENT-MONDAY"
                                    aria-labelledby="monday" aria-expanded="true">

                                </div>

                                <!-- TUESDAY panel -->
                                <div class="tab-pane" id="CONTENT-TUESDAY" role="tabpanel" aria-labelledby="TUESDAY"
                                    aria-expanded="false">

                                </div>

                                <!-- cancellation return  -->
                                <div class="tab-pane" id="CONTENT-WEDNESDAY" role="tabpanel" aria-labelledby="WEDNESDAY"
                                    aria-expanded="false">


                                </div>

                                <!-- my order -->
                                <div class="tab-pane" id="CONTENT-THURSDAY" role="tabpanel" aria-labelledby="my-order"
                                    aria-expanded="false">

                                </div>

                                <!-- product services -->
                                <div class="tab-pane" id="CONTENT-FRIDAY" role="tabpanel"
                                    aria-labelledby="product-services" aria-expanded="false">
                                    <!-- icon and header -->

                                </div>

                                <div class="tab-pane" id="CONTENT-SATURDAY" role="tabpanel"
                                    aria-labelledby="product-services" aria-expanded="false">
                                    <!-- icon and header -->

                                </div>
                                <div class="tab-pane" id="CONTENT-SUNDAY" role="tabpanel"
                                    aria-labelledby="product-services" aria-expanded="false">
                                    <!-- icon and header -->

                                </div>



                            </div>
                        </div>
                    </div>
                </section>
                <!-- / frequently asked questions tabs pills -->
            </div>
        </div>
    </div>
</div>
<x-modal-form id="modal_form_schedule" formName="SCHEDULE" content="modal_form_schedule_content" />
@endsection

@section('vendor-script')
<!-- Vendor js files -->
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<!-- <script src="{{ asset('new-assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('new-assets/js/select2/select2.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<!-- Page js files -->
<script>
$(document).ready(function(){
    $('.js-select2').select2();
}); 

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function _loadSchedules(day) {
    $("#CURRENT_DAY").val(day);
    var loaderHtml =
        '<center><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></center>';
    $("#CONTENT-" + day).html(loaderHtml);
    var doctor_id = $("#select-doctos").val();
    $.ajax({
        type: "GET",
        url: "/admin/get/schedules/" + doctor_id + '/' + day,
        dataType: "html",
        success: function(html) {
            $("#CONTENT-" + day).html(html);
        },
        error: function(err) {
            $("#CONTENT-" + day).html(
                '<i class="fa fa-times></i> Oops! Something went wrong. Please try again later.');
        },
    }).done(function(data) {

    });
}

_getJsonDoctors("select-doctos", 0);

function _getJsonDoctors(select_id, selected_value = 0) {
    $.ajax({
        url: '/admin/json/doctors',
        dataType: 'json',
        success: function(response) {
            var array = response;
            if (array != '') {
                for (i in array) {
                    $('#' + select_id).append("<option value='" + array[i].id + "'>" + array[i].name +
                        "</option>");
                }
            }
        },
        error: function(x, e) {

        }
    }).done(function() {
        if (selected_value != 0 && selected_value != '') {
            $('#' + select_id + ' option[value="' + selected_value + '"]').attr('selected', 'selected');
        }
        $("#monday").click();
    });
}


function _formSchedule(doctor_id, day) {
    var modal_id = "modal_form_schedule";
    var modal_content_id = "modal_form_schedule_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    $("#SCHEDULE_MODAL_TITLE").html('<i class="feather icon-edit"></i> Add slot');
    $.ajax({
        url: "/admin/form/slot/" + doctor_id + "/" + day,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_SCHEDULE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/slot",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_schedule").modal("hide");
                } else {
                    _showResponseMessage("error", result.msg);
                }
            },
            error: function(error) {
                _showResponseMessage(
                    "error",
                    "Veuillez vérifier les champs du formulaire..."
                );
            },
            complete: function(resultat, statut) {
                $("#SPAN_SAVE").removeClass("spinner-border spinner-border-sm");
                var day=$("#CURRENT_DAY").val();
                _loadSchedules(day);
            },
        });
        return false;
    },
});

function _deleteSlot(id) {
    var successMsg = "Your slot time has been deleted.";
    var errorMsg = "Your slot time has not been deleted.";
    var swalConfirmTitle ="Are you sure you want to delete?";
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
                url: "/admin/delete/slot/" + id,
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
                    var day=$("#CURRENT_DAY").val();
                    _loadSchedules(day);
                },
            });
        }
    });
}
</script>
@endsection