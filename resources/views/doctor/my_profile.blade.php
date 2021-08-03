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
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.my_profile') }}</h4>

                <div class="card shadow-none bg-transparent border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-primary" onclick="_printPdfInvoices(1)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('FILE')!!} Export Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-warning" onclick="_printPdfInvoices(2)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Download Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-success" onclick="_printPdfInvoices(3)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Export Excel</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" id="filter_select">
                                    <option value="day">Last 1 day</option>
                                    <option value="week">Last 7 days</option>
                                    <option value="month">Last 30 days</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.date') }}</th>
                                <th>{{ __('locale.rate') }} (%)</th>
                                <th>
                                {{ __('locale.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                            <tr>
                                <td><span>{{ $doctor->rate_date }}</span></td>
                                <td><span>{{ is_null($doctor->rate)?'':$doctor->rate.'%' }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a data-id="{{ $doctor->id }}" title="Rate" class="btn btn-icon btn-sm btn-outline-primary rate-btn">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('VIEW')!!}</a>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="rate_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">My Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="answer_form">
                <table class="table">
                    <thead>
                        <th>Question</th>
                        <th>Answer</th>
                    </thead>
                    <tbody id="question_tbody">
                    </tbody>
                </table>
                </form>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" data-dismiss="modal" class="btn btn-primary"><i data-feather="x"></i>&nbsp;Close</button>
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
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$(document).ready(function() {
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
            data: function(d) {
                d.limit = $('#limit_select').val();
            }
        },
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 25,
        deferRender: true
    });
    $(".datatable").on('click', '.rate-btn', function(e){
        var question_id = $(e.currentTarget).data('id');
        var spinner ='<tr><td colspan="2" class="text-center"><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></td></tr>';
        $("#question_tbody").html(spinner)
        $("#rate_modal").modal('show');
        $.ajax({
            url: '/doctor/my_rate/'+question_id,
            type: "GET",
            success: function(response) {
                $("#question_tbody").html(response);
            },
        });
    })
});
function _printPdfInvoices (mode) {
    if(mode==1 || mode==2) {
        var mode_str = mode==1?"stream":"download";
        window.open('/invoices/pdf/doctor/{{Auth::user()->id}}/'+$("#filter_select").val()+'/'+mode_str, '_blank');
    }else{
        window.open('/invoices/xls/doctor/{{Auth::user()->id}}/'+$("#filter_select").val());
    }
}
</script>
@endsection