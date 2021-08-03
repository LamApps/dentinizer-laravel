@extends('layouts/layoutMaster')

@section('title', 'Backups')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.backup') }}</h4>
                <div class="row">
                    <!-- <div class="col-md-12 clearfix">
                        <a id="create-new-backup-button" href="{{ url('/admin/backup/create') }}"
                            class="btn btn-outline-primary btn-sm" style="margin-bottom:2em;"><i
                                data-feather="plus"></i>
                            Create New Backup
                        </a>
                    </div> -->

                    <div class="col-md-12">
                        <p>{{ __('locale.text_backup_1') }}</p>
                        <p>{{ __('locale.text_backup_2') }}</p>
                    </div>

                    <div class="col-md-12">
                        @if ( Session::has('success') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ Session::get('success') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ( Session::has('update') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ Session::get('update') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ( Session::has('delete') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ Session::get('delete') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        @if (count($backups))

                        <div class="table-responsive">
                            <table id="backup_datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>File Size</th>
                                        <th>Created Date</th>
                                        <th>Created Age</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($backups as $backup)
                                    <tr>
                                        <td>{{ $backup['file_name'] }}</td>
                                        <td>{{ \App\Library\Helpers\Helper::humanFilesize($backup['file_size']) }}</td>
                                        <td>
                                            {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-outline-primary btn-sm"
                                                href="{{ url('admin/backup/download/'.$backup['file_name']) }}"><i
                                                    data-feather="download"></i> Download</a>
                                            <button class="btn btn-outline-danger btn-sm" onclick="_deleteBackup('{{$backup['file_name']}}')"
                                                type="button"><i
                                                    data-feather="trash"></i>
                                                Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        @else
                        <div class="well">
                            <h4>{{ __('locale.there_are_no_backup') }}</h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
@if (count($backups))
var table = $('#backup_datatable');
table.DataTable({
    responsive: true,
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
});
@endif

function _deleteBackup(file_name) {
    var successMsg = "Successfully deleted backup!";
    var errorMsg = "File has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete this file?";
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
                url: "/admin/backup/delete/" + file_name,
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
                    //_reload_dt_logs();
                    location.reload();
                },
            });
        }
    });
}
</script>
@endsection