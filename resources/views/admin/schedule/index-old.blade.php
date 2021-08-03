@extends('layouts.layoutMaster')

@section('content')

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Doctor Schedule Timings</li>
    </ol>
</div>
<div class="content-wrapper">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
            <h5 class='text-success'>Doctor Schedule Timings</h5>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="select-doctos" class="form-label">Choose doctor</label>
                            <select class="form-select" id="select-doctos">
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-monday-tab" data-bs-toggle="pill"
                                onclick="_loadSchedules('MONDAY')" data-bs-target="#v-pills-monday" type="button"
                                role="tab" aria-controls="v-pills-monday" aria-selected="true">MONDAY</button>
                            <button class="nav-link" id="v-pills-tuesday-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-tuesday" type="button" role="tab"
                                aria-controls="v-pills-tuesday" aria-selected="false">TUESDAY</button>
                            <button class="nav-link" id="v-pills-wednesday-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-wednesday" type="button" role="tab"
                                aria-controls="v-pills-wednesday" aria-selected="false">WEDNESDAY</button>
                            <button class="nav-link" id="v-pills-thursday-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-thursday" type="button" role="tab"
                                aria-controls="v-pills-thursday" aria-selected="false">THURSDAY</button>
                            <button class="nav-link" id="v-pills-thursday-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-friday" type="button" role="tab" aria-controls="v-pills-friday"
                                aria-selected="false">FRIDAY</button>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent-schedules">
                            <div class="tab-pane fade show active" id="v-pills-monday" role="tabpanel"
                                aria-labelledby="v-pills-monday-tab">
                                <div class="card">
                                    <div class="card-body" id="CONTENT-MONDAY">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-tuesday" role="tabpanel"
                                aria-labelledby="v-pills-tuesday-tab">c2</div>
                            <div class="tab-pane fade" id="v-pills-wednesday" role="tabpanel"
                                aria-labelledby="v-pills-wednesday-tab">c3</div>
                            <div class="tab-pane fade" id="v-pills-thursday" role="tabpanel"
                                aria-labelledby="v-pills-thursday-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-friday" role="tabpanel"
                                aria-labelledby="v-pills-friday-tab">c friday</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="set_slot_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Set Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="target_set_btn"><span
                        class="icon-settings1"></span>&nbsp;Save</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><span
                        class="icon-close"></span>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
@endsection

@section('page-script')
<!-- Page js files -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" />
<script>

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

function _loadSchedules(day) {
    var loaderHtml = '<center><i class="fa fa-spinner fa-spin"></i> loading ...</center>';
    $("#CONTENT-" + day).html(loaderHtml);
    var doctor_id = $("#select-doctos").val();
    $.ajax({
        type: "GET",
        url: "/admin/get/schedules/"+doctor_id+'/'+day,
        dataType: "html",
        success: function(html) {
            $("#CONTENT-" + day).html(html);
        },
        error: function(err) {
            $("#CONTENT-" + day).html('<i class="fa fa-times></i> Oops! Something went wrong. Please try again later.');
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
    });
}
</script>
@endsection