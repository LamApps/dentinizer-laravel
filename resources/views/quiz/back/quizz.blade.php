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
$lang = 'en';
if (session()->has('locale')) {
$lang = session()->get('locale');
}
@endphp
<?php if($type==0): ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.quizz') }}</h4>

                <div class="col-md-4">
                    <form id="formFilterSearch">
                        <label for="">{{ __('locale.search') }} :</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="filter_text" placeholder=""
                                aria-describedby="button-filter" />
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



                <?php if($lang =='en') : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:70%;right:50%;width:60px" type="button" onclick="_formQuiz(0)"
                        class="btn btn-icon btn-sm btn-outline-primary"> <i data-feather="plus"></i></button>
                </div>
                <?php  else : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:50%;right:70%;width:60px" type="button" onclick="_formQuiz(0)"
                        class="btn btn-icon btn-sm btn-outline-primary"> <i data-feather="plus"></i></button>
                </div>
                <?php  endif ?>




                <div class="table-responsive">
                    <table id="quiz_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.category') }}</th>
                                <th>{{ __('locale.isActive') }}</th>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_quiz">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quiz_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_QUIZ">
                    <div id='modal_form_quiz_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i data-feather="save"></i> Save <span
                        id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->


<?php elseif($type== 1 ) : ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.question') }}</h4>
                <div class="col-md-4">
                    <form id="formFilterSearch">
                        <label for="">{{ __('locale.search') }} :</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="filter_text" placeholder=""
                                aria-describedby="button-filter" />
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

                <div class="row">
                    <?php if($lang =='en') : ?>
                    <div class="col-md-8">
                        <button style="position:relative;left:70%;right:50%;width:60px" type="button"
                            onclick="_formQuestions(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                                data-feather="plus"></i></button>
                    </div>
                    <?php  else : ?>
                    <div class="col-md-8">
                        <button style="position:relative;left:50%;right:70%;width:60px" type="button"
                            onclick="_formQuestions(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                                data-feather="plus"></i></button>
                    </div>
                    <?php  endif ?>
                </div>


                <div class="table-responsive">
                    <table id="question_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.text') }}</th>
                                <th>{{ __('locale.quizz') }}</th>
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_question">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Question_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_QUESTION">
                    <div id='modal_form_Question_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i data-feather="save"></i>
                    Save <span id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i>
                    Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<?php elseif($type==3) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.category') }}</h4>

                <div class="col-md-4">
                    <form id="formFilterSearch">
                        <label for="">{{ __('locale.search') }} :</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="filter_text" placeholder=""
                                aria-describedby="button-filter" />
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



                <?php if($lang =='en') : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:70%;right:50%;width:60px" type="button"
                        onclick="_formCategory(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                            data-feather="plus"></i></button>
                </div>
                <?php  else : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:50%;right:70%;width:60px" type="button"
                        onclick="_formCategory(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                            data-feather="plus"></i></button>
                </div>
                <?php  endif ?>




                <div class="table-responsive">
                    <table id="category_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.code') }}</th>
                                <th>{{ __('locale.name') }}</th>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_category">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CATEGORY_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_CATEGORY">
                    <div id='modal_form_CATEGORY_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i data-feather="save"></i> Save <span
                        id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<?php  elseif($type==2) : ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.answer') }}</h4>

                <div class="col-md-4">
                    <form id="formFilterSearch">
                        <label for="">{{ __('locale.search') }} :</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="filter_text" placeholder=""
                                aria-describedby="button-filter" />
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



                <?php if($lang =='en') : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:70%;right:50%;width:60px" type="button"
                        onclick="_formAnswer(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                            data-feather="plus"></i></button>
                </div>
                <?php  else : ?>
                <div class="col-md-8">
                    <button style="position:relative;left:50%;right:70%;width:60px" type="button"
                        onclick="_formAnswer(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                            data-feather="plus"></i></button>
                </div>
                <?php  endif ?>

                <div class="table-responsive">
                    <table id="answer_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.text') }}</th>
                                <th>{{ __('locale.is_true') }}</th>
                                <th>{{ __('locale.question') }}</th>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_answer">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ANSWER_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_ANSWER">
                    <div id='modal_form_ANSWER_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i data-feather="save"></i> Save <span
                        id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<?php elseif($type==4) : ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.tests') }}</h4>
                <div class="col-md-4">
                    <form id="formFilterSearch">
                        <label for="">{{ __('locale.search') }} :</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="filter_text" placeholder=""
                                aria-describedby="button-filter" />
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

                <?php if($lang =='en') : ?>
                <div class="col-md-8">
                <button style="position:relative;left:70%;right:50%;width:60px" type="button"
                            onclick="_formTest(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                                data-feather="plus"></i></button>
                </div>
                <?php  else : ?>
                <div class="col-md-8">
                <button style="position:relative;left:50%;right:70%;width:60px" type="button"
                            onclick="_formTest(0)" class="btn btn-icon btn-sm btn-outline-primary"> <i
                                data-feather="plus"></i></button>
                </div>
                <?php  endif ?>




                <div class="table-responsive">
                    <table id="test_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.id') }}</th>
                                <th>{{ __('locale.doctor') }}</th>
                                <th>{{ __('locale.quizz') }}</th>
                                <th>{{ __('locale.Nquestion') }}</th>
                                <th>{{ __('locale.Dmarks') }}</th>
                                <th>{{ __('locale.Tmarks') }}</th>
                                <th>{{ __('locale.quiz.average') }}</th>
                                <th>{{ __('locale.status') }}</th>
                                <th> {{ __('locale.actions') }}
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_test">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TEST_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_TEST">
                    <div id='modal_form_TEST_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i data-feather="save"></i> Save <span
                        id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<?php endif ?>

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
<?php if($type== 0) :?>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/quizz/0';
    var table = $('#quiz_datatable').DataTable({
        responsive: true,
        @if($lang == 'ar')
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
var _reload_quiz_datatable = function() {
    $('#quiz_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_quiz_datatable();
});

function _formQuiz(id) {

    var modal_id = "modal_form_quiz";
    var modal_content_id = "modal_form_quiz_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit quiz' : 'Add quiz';
    $("#quiz_MODAL_TITLE").html('{!! \App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ') !!} ' + modalTitle);
    $.ajax({
        url: "/quiz/form/quiz/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};


var table_quiz = $('quiz_datatable');
$("#FORM_QUIZ").submit(function(event) {
    // alert("hello");
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/quiz/submit',
        success: function(response) {
            if (response.success) {
                $("#modal_form_quiz").modal('hide');
                _showResponseMessage("success", response.msg);
                // table_quiz.DataTable().ajax.reload();
                if (response.id != 0) {

                    //  $("#modal_form_quiz_body" + ).html(spinner);
                    //s alert(hello achraf);
                    _formQuiz(response.id);
                    $("#modal_form_quiz").modal('show');

                }
                _reload_quiz_datatable();

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

function _submit_form() {
    $("#FORM_QUIZ").submit();
}




function _submit_search_form() {
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
<?php elseif($type==1) :?>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/quiz_Question/0';
    var table = $('#question_datatable').DataTable({
        responsive: true,
        @if($lang == 'ar')
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

var _reload_question_datatable = function() {
    $('#question_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_question_datatable();
});

function _formQuestions(id) {
    var modal_id = "modal_form_question";
    var modal_content_id = "modal_form_Question_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit question' : 'Add question';
    $("#Question_MODAL_TITLE").html('{!! \App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ') !!} ' + modalTitle);
    $.ajax({
        url: "/form/quiz_question/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};


var table_question = $('question_datatable');
$("#FORM_QUESTION").submit(function(event) {
    // alert("hello");
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/question/submit',
        success: function(response) {
            if (response.success) {
                $("#modal_form_question").modal('hide');
                _showResponseMessage("success", response.msg);
                _reload_question_datatable();

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




function _submit_form() {
    $("#FORM_QUESTION").submit();
}
</script>
<?php elseif($type==3) :?>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/quiz_Category/0';
    var table = $('#category_datatable').DataTable({
        responsive: true,
        @if($lang == 'ar')
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

var _reload_category_datatable = function() {
    $('#category_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_category_datatable();
});

function _formCategory(id) {
    var modal_id = "modal_form_category";
    var modal_content_id = "modal_form_CATEGORY_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit category' : 'Add category';
    $("#CATEGORY_MODAL_TITLE").html('{!! \App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ') !!} ' + modalTitle);
    $.ajax({
        url: "/form/quiz_category/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};


var table_question = $('category_datatable');
$("#FORM_CATEGORY").submit(function(event) {
    // alert("hello");
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/category/submit',
        success: function(response) {
            if (response.success) {
                $("#modal_form_category").modal('hide');
                _showResponseMessage("success", response.msg);
                _reload_category_datatable();

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




function _submit_form() {
    $("#FORM_CATEGORY").submit();
}
</script>
<?php elseif($type ==2) : ?>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/quiz_Answer/0';
    var table = $('#answer_datatable').DataTable({
        responsive: true,
        @if($lang == 'ar')
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

var _reload_answer_datatable = function() {
    $('#answer_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_answer_datatable();
});

function _formAnswer(id) {
    var modal_id = "modal_form_answer";
    var modal_content_id = "modal_form_ANSWER_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit Answer' : 'Add Answer';
    $("#ANSWER_MODAL_TITLE").html('{!! \App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ') !!} ' + modalTitle);
    $.ajax({
        url: "/form/quiz_answer/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};


var table_question = $('answer_datatable');
$("#FORM_ANSWER").submit(function(event) {
    // alert("hello");
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/answer/submit',
        success: function(response) {
            if (response.success) {
                $("#modal_form_answer").modal('hide');
                _showResponseMessage("success", response.msg);
                _reload_answer_datatable();

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




function _submit_form() {
    $("#FORM_ANSWER").submit();
}
</script>
<?php elseif($type==4) :?>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var dtUrl = '/quiz_test/0';
    var table = $('#test_datatable').DataTable({
        responsive: true,
        @if($lang == 'ar')
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

var _reload_test_datatable = function() {
    $('#test_datatable').DataTable().ajax.reload();
}
$('#limit_select').on('change', function() {
    _reload_test_datatable();
});

function _formTest(id) {
    var modal_id = "modal_form_test";
    var modal_content_id = "modal_form_TEST_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit test' : 'Add test';
    $("#ANSWER_MODAL_TITLE").html('{!! \App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ') !!} ' + modalTitle);
    $.ajax({
        url: "/form/quiz_test/" + id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};


var table_question = $('test_datatable');
$("#FORM_TEST").submit(function(event) {
    // alert("hello");
    event.preventDefault();
    $("#SPAN_SAVE_APPOINTMENT").addClass("spinner-border spinner-border-sm");
    var formData = $(this).serializeArray();
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/test/submit',
        success: function(response) {
            if (response.success) {
                $("#modal_form_test").modal('hide');
                _showResponseMessage("success", response.msg);
                _reload_test_datatable();

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




function _submit_form() {
    $("#FORM_TEST").submit();
}
</script>
<?php endif ?>
@endsection