@extends('layouts/layoutMaster')

@section('title', 'My quizs')

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
                <h4 class="card-title">{{ __('locale.test') }}</h4>
                <form id="FORM_QUIZ">
                    <div class="modal-body modal-body-lg">
                        <div id='modal_form_quiz_body'>
                            {{ csrf_field() }}
                            <input type="hidden" name="question_number" value="{{$cq}}" />
                            <input type="hidden" name="test_id" value="{{$test->id}}" />
                            <input type="hidden" name="question_id" value="{{$question->id}}" />

                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label class="form-label" for="question">{{$question->text}}</label>

                                        @foreach($answers as $answer)
                                        <div>
                                            <input type="radio" name="answer" id="answer{{$answer->id}}"
                                                value="{{$answer->id}}" required>
                                            <label for="answer{{$answer->id}}">{{$answer->text}}</label>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-outline-danger"><i
                                data-feather="x"></i>{{__('locale.cancel')}}</button>
                        <button type="submit" class="btn btn-outline-primary"><i
                                data-feather="save"></i>{{__('locale.next')}}<span id="SPAN_SAVE_QUIZ" class=""
                                role="status" aria-hidden="true"></span></button>
                    </div>
                </form>
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
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>


<script>
    $("#FORM_QUIZ").submit(function (event) {
            event.preventDefault();
            $("#SPAN_SAVE_QUIZ").addClass("spinner-border spinner-border-sm");
            var formData = $(this).serializeArray();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: formData,
                url: '/doctor/form/quiz',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        //$("#modal_form_quiz").modal('hide');
                       // _showResponseMessage("success", response.msg);
                        setTimeout(function () {
                            _startQuiz(test_id, "in_progress", response.test_id);
                        },1000);


                    } else if (response.completed) {
                        $("#modal_form_quiz").modal('hide');
                    } else {
                        _showResponseMessage("error", response.msg);
                    }
                },
                error: function () {
                }
            }).done(function (data) {
                $("#SPAN_SAVE_QUIZ").removeClass("spinner-border spinner-border-sm");
            });
            return false;
        });
</script>

@endsection