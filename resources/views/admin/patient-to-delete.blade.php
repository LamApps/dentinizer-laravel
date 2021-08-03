@extends('layouts/layoutMaster')

@section('title', 'Patient Lists')

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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Patients List</h4>
                <div class="table-responsive">
                    <table id="patients_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Arabic Name</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>
                                    Actions
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


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_patient_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Add Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">Full Name*</label>
                            <input type="text" id="a_name" name="a_name" class="form-control form-control-lg"
                                placeholder="Enter Full name" require>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="display-name">Email*</label>
                            <input type="text" id="a_email" name="a_email" class="form-control form-control-lg"
                                placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="birth-day">Date of Birth</label>
                            <input type="text" id="a_birthday" name="a_birthday" data-date-format="yyyy-mm-dd"
                                class="form-control datepicker" placeholder="Enter your birthday">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phone-no">Phone Number</label>
                            <input type="text" id="a_phone" name="a_phone" class="form-control form-control-lg"
                                placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="a_address" name="a_address" class="form-control form-control-lg"
                                placeholder="Enter address">
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="patient_save_btn"><span
                        class="icon-save2"></span>&nbsp;Save</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><span
                        class="icon-close"></span>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="edit_patient_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="e_patient_id" name="e_patient_id">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">Full Name*</label>
                            <input type="text" id="e_name" name="e_name" class="form-control form-control-lg"
                                placeholder="Enter Full name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="display-name">Email*</label>
                            <input type="text" id="e_email" name="e_email" class="form-control form-control-lg"
                                placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="birth-day">Date of Birth</label>
                            <input type="text" id="e_birthday" name="e_birthday" data-date-format="yyyy-mm-dd"
                                class="form-control form-control-lg datepicker" placeholder="Enter your birthday">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phone-no">Phone Number</label>
                            <input type="text" id="e_phone" name="e_phone" class="form-control form-control-lg"
                                placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="e_address" name="e_address" class="form-control form-control-lg"
                                placeholder="Enter address">
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="patient_update_btn"><span
                        class="icon-save2"></span>&nbsp;Update</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><span
                        class="icon-close"></span>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<x-modal-form id="modal_form_patient" formName="PATIENT" content="modal_form_patient_content" />
@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
function delete_func(val) {
    document.getElementById(val).submit();
}
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/admin/sdt/patients';
    var table = $('#patients_datatable').DataTable({
        responsive: true,
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
    





    //$(".datepicker").da

    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        hiddenName: true
    })
    $("#patient_save_btn").click(function(e) {
        e.preventDefault();
        var name = $("#a_name").val();
        var email = $("#a_email").val();
        var birthday = $("#a_birthday").val();
        var phone = $("#a_phone").val();
        var address = $("#a_address").val();
        if (name != "" && email != "") {
            $.ajax({
                url: '{{route("admin.patient.store")}}',
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    birthday: birthday,
                    phone: phone,
                    address: address,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $("#add_patient_modal").modal('hide');
                    NioApp.Toast('Success.', 'success');
                    toastr.clear();
                    window.location.href = '{{route("admin.patient")}}';
                },
            });
        }
    });



    $('#edit_patient_modal').on('show.bs.modal', function(e) {
        var patient_data = $(e.relatedTarget).data('id');
        $("#e_patient_id").val(patient_data['id']);
        $("#e_name").val(patient_data['name']);
        $("#e_email").val(patient_data['email']);
        $("#e_phone").val(patient_data['phone']);
        $("#e_birthday").val(patient_data['birthday']);
        $("#e_address").val(patient_data['address']);
    });


    $("#patient_update_btn").click(function(e) {
        e.preventDefault();
        var id = $("#e_patient_id").val();
        var name = $("#e_name").val();
        var email = $("#e_email").val();
        var birthday = $("#e_birthday").val();
        var phone = $("#e_phone").val();
        var address = $("#e_address").val();
        if (name != "" && email != "") {
            $.ajax({
                url: '{{route("admin.patient.store")}}',
                type: "PUT",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    birthday: birthday,
                    phone: phone,
                    address: address,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $("#edit_patient_modal").modal('hide');
                    NioApp.Toast('Success.', 'success');
                    toastr.clear();
                    window.location.href = '{{route("admin.patient")}}';
                },
            });
        }
    });


});

var _reload_patients_datatable = function() {
        $('#patients_datatable').DataTable().ajax.reload();
}

function _formPatient(id) {
    var modal_id = "modal_form_patient";
    var modal_content_id = "modal_form_patient_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (id > 0) ? 'Edit patient' : 'New patient';
    $("#PATIENT_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ')!!} ' + modalTitle);
    $.ajax({
        url: "/admin/form/patient/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_PATIENT").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_PATIENT").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/patient",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_patient").modal("hide");
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
                $("#SPAN_SAVE_PATIENT").removeClass("spinner-border spinner-border-sm");
                _reload_patients_datatable();
            },
        });
        return false;
    },
});


function _deletePatient(id) {
    var successMsg = "The patient has been deleted.";
    var errorMsg = "The patient has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete this patient?";
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
                url: "/admin/delete/patient/" + id,
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
                    //setTimeout(function(){ location.reload(); }, 2000);
                    _reload_patients_datatable();
                },
            });
        }
    });
}
</script>
@endsection