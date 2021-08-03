@extends('layouts/layoutMaster')

@section('title', 'Doctor List')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
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
                <h4 class="card-title">{{ __('locale.questions') }}</h4>
                <div class="row">
                    <div class="col-md-12">
                        
                        <button style="float: right" title="New question" class="btn btn-icon btn-outline-primary" id="add-btn">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.questions') }}</th>
                                <th>
                                {{ __('locale.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                            <tr>
                                <td><span>{{ $question->question }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-icon btn-sm btn-outline-primary edit-btn" title="Edit" data-id="{{ $question->id }}">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}</button>
                                        <button class="btn btn-icon btn-sm btn-outline-danger delete-btn" title="Delete" data-id="{{ $question->id }}">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}</button>
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


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="question_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="question_form">
            {{ csrf_field() }}
            <div class="modal-body">
                    <input type="hidden" id="sel_id" name="sel_id">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="display-name">Question *</label>
                                <input type="text" id="question" name="question" class="form-control form-control-lg"
                                    placeholder="Please input a question string...">
                            </div>
                        </div>
                    </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="save-btn"><i data-feather="save"></i>&nbsp;Save</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>
            </div>
            </form>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->


@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<!-- responsive -->
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>


@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
function delete_func(val) {
    document.getElementById(val).submit();
}
$(document).ready(function() {
    var table = $('.datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
    });


    $(".edit-btn").click(function(e){
        e.preventDefault();
        var $elem = $(e.currentTarget);
        $("#sel_id").val($elem.data('id'));
        $("#question").val($elem.parents('tr').first().text().trim());
        $("#question_modal").modal('show');
    });
    $("#add-btn").click(function(){
        $("#sel_id").val('');
        $("#question").val('');
        $("#question_modal").modal('show');
    });
    $(".delete-btn").click(function(e){
        var id = $(e.currentTarget).data('id');
        // console.log(id);
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "/admin/question_delete",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: "JSON",
                success: function(result) {
                    if (result.success) {
                        _showResponseMessage("success", result.msg);
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
                    // setTimeout(function(){ window.location.href = '{{route("admin.doctor.questions")}}'; }, 1500);
                },
            });

          }
        })
    });
    $("#question_form").validate({
        rules: {
           question: 'required' 
        },
        submitHandler: function(form) {
            var formData = $(form).serializeArray(); // convert form to array
            $.ajax({
                type: "POST",
                url: "/admin/question_save",
                data: formData,
                dataType: "JSON",
                success: function(result) {
                    if (result.success) {
                        _showResponseMessage("success", result.msg);
                        $("#question_form").modal("hide");
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
                    setTimeout(function(){ window.location.href = '{{route("admin.doctor.questions")}}'; }, 1500);
                },
            });
            return false;
        },
    });
    // $("#save-btn").click(function(e) {
    //     console.log(1);
    //     e.preventDefault();

    // });


});


</script>
@endsection


