@extends('layouts/layoutMaster')

@section('title', 'Users List')

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
                <h4 class="card-title">{{ __('locale.users') }}</h4>
                <!-- <h5 class='text-success'>You have total {{ count($users) }} users.</h5> -->

                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.username') }}</th>
                                <th>{{ __('locale.type') }}</th>
                                <th>{{ __('locale.state') }}</th>
                                <th>{{ __('locale.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($users as $user)
                            <tr>
                                <td><span>{{ $user->name }}</span></td>
                                <td><span>{{ $user->username }}</span></td>
                                <td><span>{{ $user->user_type }}</span></td>
                                <td>
                                    <span>
                                        @if($user->state == 1)
                                        <span class="tb-status text-success">Verified</span>
                                        @elseif($user->state == 0)
                                        <span class="tb-status text-warning">Pending</span>
                                        @elseif($user->state == 2)
                                        <span class="tb-status text-danger">Suspend</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        @if($user->state != 1)
                                        <div onclick="set_state_func('verify_frm_{{ $user->id }}')">
                                            <form
                                                action="{{ route('admin.users.setstate', ['user_id'=>$user->id, 'key'=>1] )}}"
                                                name="verify_frm_{{ $user->id }}" id="verify_frm_{{ $user->id }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <a class="dropdown-item" href="#"><i data-feather="check"></i><span>&nbsp;Verify</span></a>
                                            </form>
                                        </div>
                                        @endif
                                        @if($user->state != 2)
                                        <div onclick="set_state_func('suspend_frm_{{ $user->id }}')">
                                            <form
                                                action="{{ route('admin.users.setstate', ['user_id'=>$user->id, 'key'=>2] )}}"
                                                name="suspend_frm_{{ $user->id }}" id="suspend_frm_{{ $user->id }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <a class="dropdown-item" href="#"><i data-feather="slash"></i><span>&nbsp;Suspend User</span></a>
                                            </form>
                                        </div>
                                        @endif
                                        <div onclick="reset_pass_func('resetpass_frm_{{ $user->id }}')">
                                            <form action="{{ route('admin.users.resetpass', $user->id)}}"
                                                name="resetpass_frm_{{ $user->id }}" id="resetpass_frm_{{ $user->id }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <a class="dropdown-item" href="#"><i data-feather="lock"></i><span>&nbsp;Reset Pass</span></a>
                                            </form>
                                        </div>
                                        <div data-toggle="modal" data-target="#set_type_modal" data-id="{{ $user }}"><a
                                                class="dropdown-item" style="cursor:pointer;"><i data-feather="settings"></i><span>&nbsp;Set Type</span></a></div>
                                        <!-- <div onclick="delete_func('delete_frm_{{ $user->id }}')">
                                            <form action="{{ route('admin.users.destroy', $user->id)}}"
                                                name="delete_frm_{{ $user->id }}" id="delete_frm_{{ $user->id }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="dropdown-item" href="#" style="color:#e85347"><i data-feather="trash"></i><span>&nbsp;Remove</span></a>
                                            </form>
                                        </div> -->
                                        <!-- <div onclick="delete_func('delete_frm_{{ $user->id }}')">
                                            <form action="{{ route('admin.users.destroy', $user->id)}}"
                                                name="delete_frm_{{ $user->id }}" id="delete_frm_{{ $user->id }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="dropdown-item" href="#" style="color:#e85347"><i data-feather="trash"></i><span>&nbsp;Remove</span></a>
                                            </form>
                                        </div> -->
                                        @if(Auth::user()->id!=$user->id)
                                        <a class="dropdown-item" style="color:#e85347;cursor:pointer;" onclick="_deleteUser({{ $user->id }})" title="Delete"><i data-feather="trash"></i> Remove</a>
                                        @endif
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



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="set_type_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Set Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="user_id" name="user_id">
                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">Email</label>
                            <input type="text" id="email" name="email" class="form-control form-control-lg" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Types</label>
                            <div class="form-control-wrap">
                                <select class="form-control form-control-lg selectpicker" data-live-search="true"
                                    id="user_type" name="user_type">
                                    <option value="admin">Admin</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="reception">Reception</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="set_type_btn"><i data-feather="save"></i>&nbsp;Set</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<!-- @@ Set Type Modal @e -->


@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
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
    $('#set_type_modal').on('show.bs.modal', function(e) {
        var user_data = $(e.relatedTarget).data('id');
        $("#user_id").val(user_data['id']);
        $("#email").val(user_data['email']);
    });


    $("#set_type_btn").click(function(e) {
        e.preventDefault();
        var id = $("#user_id").val();
        var user_type = $("#user_type").val();
        $.ajax({
            url: '{{ route("admin.users.settype") }}',
            type: "PUT",
            data: {
                id: id,
                user_type: user_type,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $("#set_type_modal").modal('hide');
                _showResponseMessage("success", 'Success.');
                setTimeout(function(){ window.location.href = '{{route("admin.users")}}'; }, 1500);
            },
        });

    });



});

function delete_func(val) {
    document.getElementById(val).submit();
}

function set_state_func(val) {
    document.getElementById(val).submit();
}

function reset_pass_func(val) {
    swal.fire({
        title: "Hello!",
        text: "The password will be reset with 12345.",
        icon: "success",
    });
    setTimeout(function(){ document.getElementById(val).submit(); }, 1500);
}


function _deleteUser(id) {
    var successMsg = "The user has been deleted.";
    var errorMsg = "The user has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete this user?";
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
                url: "/admin/delete/user/" + id,
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