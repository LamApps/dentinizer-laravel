@extends('layouts/layoutMaster')

@section('title', 'My quizs')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet"
          href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.date.css') }}"/>
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
                    <h4 class="card-title">{{ __('locale.quizs') }}</h4>

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
                                           name="filter_text" placeholder="" aria-describedby="button-filter"/>
                                    <div class="input-group-append" id="button-filter">
                                        <button class="btn btn-outline-primary btn-sm" type="button"
                                                onclick='_submit_search_form();'><i data-feather="search"></i></button>
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
                        <table id="quiz_datatable" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{ __('locale.quiz.name') }}</th>
                                <th>{{ __('locale.quiz.nbr_questions') }}</th>
                                <th>{{ __('locale.quiz.user_marks') }}</th>
                                <th>{{ __('locale.quiz.total_quiz_marks') }}</th>
                                <th>{{ __('locale.quiz.status') }}</th>
                                <th>{{ __('locale.category') }}</th>
                                <th>
                                    {{ __('locale.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quizs as $quiz)
                                <tr>
                                    <td><span>{{ $quiz->name }}</span></td>
                                    <td><span>{{ $quiz->nb_questions }}</span></td>
                                    <td><span>{{ $quiz->user_marks }}</span></td>
                                    <td><span>{{ $quiz->total_quizz_marks }}</span></td>
                                    <!-- Status -->
                                    <td>
                                        @if($quiz->status == "to_pass")
                                            <span style="color: red"> {{__('locale.quiz.to_pass')}}</span>
                                        @elseif($quiz->status == "finished")
                                            <span style="color: green"> {{__('locale.quiz.finished')}}</span>
                                        @elseif($quiz->status == "in_progress")
                                            <span style="color: blue"> {{__('locale.quiz.in_progress')}}</span>
                                        @elseif($quiz->status == "not_completed")
                                            <span style="color: orange"> {{__('locale.quiz.not_completed')}}</span>
                                        @endif

                                    </td>
                                    <!-- Category name -->
                                    <td><span>{{ $quiz->category_name }}</span></td>
                                    <!-- Action -->
                                    <td>
                                        @if($quiz->status == "to_pass")
                                            <a type="button"
                                               href="/doctor/form/test/{{$quiz->id}}/{{$quiz->status}}/0"
                                                    class="btn btn-sm btn-outline-primary">
                                                {{__('locale.quiz.pass')}}
                                            </a>
                                        @elseif($quiz->status == "not_completed")
                                            <button type="button"
                                                    onclick="_startQuiz({{$quiz->id}},'{{$quiz->status}}');"
                                                    class="btn btn-sm btn-outline-primary">
                                                {{__('locale.quiz.continue')}}
                                            </button>
                                        @endif
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



@endsection


@section('vendor-script')
    <script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script
        src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('new-assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function () {
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
                    data: function (d) {
                        d.limit = $('#limit_select').val();
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                pageLength: 25,
                deferRender: true
            });
        });

        var _reload_quizs_datatable = function () {
            $('#quiz_datatable').DataTable().ajax.reload();
        }

        $('#limit_select').on('change', function () {
            _reload_patients_datatable();
        });

        var _startQuiz = function (id, status, cq = 0) {

            var currentQuestion = cq;
            var modal_id = "modal_form_quiz";
            var modal_content_id = "modal_form_quiz_body";
            var spinner =
                '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
            $("#" + modal_id).modal("show");
            //  $("#" + modal_content_id).html(spinner);
            var modalTitle = '{{__('locale.quiz.question')}} : ' + (currentQuestion + 1);
            $("#QUIZ_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} ' + modalTitle);
            $.ajax({
                url: "/doctor/form/test/" + id + "/" + status + "/" + currentQuestion,
                type: "GET",
                dataType: "html",
                success: function (html, status) {
                    $("#" + modal_content_id).html(html);
                },
            });

        }

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
                        $("#modal_form_quiz").modal('hide');
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

        function _submit_form() {
            $("#SUBMIT_APPOINTMENT_FORM").click();
        }


    </script>
@endsection
