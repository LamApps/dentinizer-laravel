@extends('layouts/layoutMaster')

@section('title', 'Appointments Lists')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.date.css') }}" />
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
                <h4 class="card-title">{{ __('locale.appointments') }}</h4>

                <div class="row mb-2">
                    <div class="col-md-10">

                    </div>
                    <div class="col-md-2 text-right">
                        <!-- <a href="#" id="new_service_btn" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#add_appointment_modal"><span class="icon-plus1"></span></a> -->
                        <button onclick="_formAppointment(0)" class="btn btn-icon btn-outline-primary"><i data-feather="plus"></i></button>
                    </div>
                </div>

                

                <div class="table-responsive">
                    <table class="datatable table table-striped dataex-html5-selectors table-bordered">
                        <thead>
                            <tr>
                                <th>{{__('locale.patient')}}</th>
                                <th>{{__('locale.doctor')}}</th>
                                <th>{{__('locale.start_time')}}</th>
                                <th>{{__('locale.duration')}}</th>
                                <th>{{__('locale.comments')}}</th>
                                <th>{{__('locale.status')}}</th>
                                <th>{{__('locale.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($appointments) as $appointment)
                            <tr>
                                <td style="cursor:pointer">
                                    <span onClick="window.location.href = '/profile/patient/{{$appointment->patient_id}}'">{{ ($appointment->ar_name)?$appointment->ar_name:$appointment->name }}</span>
                                </td>
                                <td onClick="window.location.href = '/profile/patient/{{$appointment->patient_id}}'"
                                    style="cursor:pointer">
                                    <span>{{ ($appointment->doctor_name)?$appointment->doctor_name:'' }}</span>
                                </td>
                                <td><span>{{ $appointment->start_time }}</span></td>
                                <td><span>{{ $appointment->duration }}</span></td>
                                <td><span>{{ $appointment->comments }}</span></td>
                                <td>
                                    @if($appointment->status == 1)
                                    <span class="tb-status text-success">Booked</span>
                                    @elseif($appointment->status == 2)
                                    <span class="tb-status text-warning">Confirmed</span>
                                    @elseif($appointment->status == 3)
                                    <span class="tb-status text-danger">Canceled</span>
                                    @elseif($appointment->status == 4)
                                    <span class="tb-status text-info">Attended</span>
                                    @else
                                    <span class="tb-status">None</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" onclick="_formAppointment({{$appointment->id}})"
                                            class="btn btn-outline-info">
                                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}
                                        </button>
                                        <!-- <button onclick="delete_func('delete_frm_{{ $appointment->id }}')" type="button"
                                            class="btn btn-outline-danger">
                                            <form action="{{ route('reception.appointment.destroy', $appointment->id)}}"
                                                name="delete_frm_{{ $appointment->id }}"
                                                id="delete_frm_{{ $appointment->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <i data-feather="trash"></i>
                                            </form>

                                        </button> -->
                                        <button class="btn btn-outline-danger" onclick="_deleteAppointment({{ $appointment->id }})" title="Delete"><i data-feather="trash"></i></button>
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

<input type="hidden" id="INPUT_HIDDEN_EDIT_APPONTMENT" value="Edit Appointment">
<input type="hidden" id="INPUT_HIDDEN_NEW_APPONTMENT" value="Add Appointment">
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
<!--             <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="birth-day">Date of Birth</label>
                            <input type="text" id="a_birthday" name="a_birthday" data-date-format="yyyy-mm-dd" class="form-control form-control-lg datepicker" placeholder="Enter your birthday">
                        </div>
                    </div> -->
            <form id="FORM_APPOINTMENT">
                    <div id='modal_form_appointment_body'>
                    </div>
                </form>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-primary" id="service_update_btn"><i data-feather="save"></i>&nbsp;Update</button>
                <button data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous"></script> -->
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
<script src="{{ asset('new-assets/js/select2/select2.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>

$(document).ready(function() {
    var table = $('.datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
    });
    
});
function show_confirm(name, notif_id) {
    swal.fire({
        title: 'Would you make an appointment for '+name+'?',
        icon: 'question',
        confirmButtonText: `Yes`,
        showDenyButton: true,
    }).then(function(result) {
        var flag = 0;
        if (result.isConfirmed) {
            flag = 1;
        } else if (result.isDenied) {
            flag = 2;
        }
        $.ajax({
            type: "post",
            url: '{{ route("reception.confirm_answer") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "flag": flag,
                "id": notif_id
            },
            success: function(data) {
                location.href='/reception/appointment';
            },
        });
    });
}
function _formAppointment(id) {
    var modal_id = "modal_form_appointment";
    var modal_content_id = "modal_form_appointment_body";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? $("#INPUT_HIDDEN_EDIT_APPONTMENT").val() : $("#INPUT_HIDDEN_NEW_APPONTMENT").val();
    $("#APPONTMENT_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} ' + modalTitle);
    $.ajax({
        url: "/reception/form/appointment/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_APPOINTMENT").submit(function(event) {
    event.preventDefault();
    var formData = $(this).serializeArray();
    //console.log(formData);
    //return false;
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/reception/form/appointment',
        success: function(response) {
            if (response.success) {
                $("#modal_form_appointment").modal('hide');
                _showResponseMessage("success", response.msg);
                setTimeout(function(){ window.location.href = '{{route("reception.appointment")}}'; }, 1500);
            } else {
                _showResponseMessage("error", response.msg);
            }
        },
        error: function() {

        }
    }).done(function(data) {

    });
    return false;
});
function delete_func(val) {
    document.getElementById(val).submit();
}
function _submit_form(){
    $("#SUBMIT_APPOINTMENT_FORM").click();
}


function _deleteAppointment(id) {
    var successMsg = "Appointment has been deleted.";
    var errorMsg = "Appointment has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete this appointment?";
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
                url: "/admin/delete/appointment/" + id,
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
                    setTimeout(function(){ location.reload(); }, 2000);
                },
            });
        }
    });
}
</script>
@endsection