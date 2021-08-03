@extends('layouts/layoutMaster')

@section('title', 'Clinic Target')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ==" crossorigin="anonymous" />
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
                <h4 class="card-title">{{ __('locale.clinic_target') }}</h4>
                <div class="row">
                    <div class="offset-md-9 col-md-2">
                        <div class="form-control-wrap">
                            <div class="form-group">
                                <input type="text" name="search_year" id="search_year" data-date-format="yyyy"
                                    class="form-control form_datetime" placeholder="Select Year">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 text-right">
                        <a href="#" id="new_service_btn" class="btn btn-icon btn-outline-primary" data-toggle="modal"
                            data-target="#add_clinic_modal"><i data-feather="plus"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('locale.year') }}</th>
                                        <th>{{ __('locale.jan') }}</th>
                                        <th>{{ __('locale.feb') }}</th>
                                        <th>{{ __('locale.mar') }}</th>
                                        <th>{{ __('locale.apr') }}</th>
                                        <th>{{ __('locale.may') }}</th>
                                        <th>{{ __('locale.jun') }}</th>
                                        <th>{{ __('locale.jul') }}</th>
                                        <th>{{ __('locale.aug') }}</th>
                                        <th>{{ __('locale.sep') }}</th>
                                        <th>{{ __('locale.oct') }}</th>
                                        <th>{{ __('locale.nov') }}</th>
                                        <th>{{ __('locale.dec') }}</th>
                                        <th>
                                        {{ __('locale.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clinics as $clinic)
                                    <tr>
                                        <td><span class="tb-status text-danger">{{ $clinic->year }}</span></td>
                                        <td><span>{{ $clinic->jan }}</span></td>
                                        <td><span>{{ $clinic->feb }}</span></td>
                                        <td><span>{{ $clinic->mar }}</span></td>
                                        <td><span>{{ $clinic->apr }}</span></td>
                                        <td><span>{{ $clinic->may }}</span></td>
                                        <td><span>{{ $clinic->jun }}</span></td>
                                        <td><span>{{ $clinic->jul }}</span></td>
                                        <td><span>{{ $clinic->aug }}</span></td>
                                        <td><span>{{ $clinic->sep }}</span></td>
                                        <td><span>{{ $clinic->oct }}</span></td>
                                        <td><span>{{ $clinic->nov }}</span></td>
                                        <td><span>{{ $clinic->dec }}</span></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" data-toggle="modal" data-target="#edit_clinic_modal"
                                                    data-id="{{ $clinic }}" class="btn btn-outline-info">
                                                    {!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}
                                                </button>
                                                <button onclick="delete_func('delete_frm_{{ $clinic->id }}')" type="button"
                                                    class="btn btn-outline-danger">
                                                    <form action="{{ route('admin.clinic.destroy', $clinic->id)}}"
                                                        name="delete_frm_{{ $clinic->id }}" id="delete_frm_{{ $clinic->id }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}
                                                    </form>
                                                </button>
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
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_clinic_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">{{ __('locale.new') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.clinic.store') }}" id="add_frm">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">

                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input class="form-control form-control-lg form-control-outlined" type="text"
                                        placeholder="Year" name="a_year" id="a_year">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.year') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_jan" name="a_jan" placeholder="Jan">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.jan') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_feb" name="a_feb" placeholder="Feb">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.feb') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_mar" name="a_mar" placeholder="Mar">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.mar') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_apr" name="a_apr" placeholder="Apr">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.apr') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_may" name="a_may" placeholder="May">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.may') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_jun" name="a_jun" placeholder="Jun">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.jun') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_jul" name="a_jul" placeholder="Jul">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.jul') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_aug" name="a_aug" placeholder="Aug">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.aug') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_sep" name="a_sep" placeholder="Sep">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.sep') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_oct" name="a_oct" placeholder="Oct">
                                    <label class="form-label-outlined" for="outlined">Oct*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_nov" name="a_nov" placeholder="Nov">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.nov') }}*</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-lg form-control-outlined"
                                        id="a_dec" name="a_dec" placeholder="Dec">
                                    <label class="form-label-outlined" for="outlined">{{ __('locale.dec') }}*</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="target_save_btn"><i data-feather="save"></i> {{ __('locale.save') }}</button>
                    <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i> {{ __('locale.cancel') }}</button>
                </div>
            </form>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="edit_clinic_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">{{ __('locale.edit') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.clinic.update') }}" id="edit_frm">
                @csrf
                <input type="hidden" id="e_clinic_id" name="e_clinic_id">
                <div class="modal-body">
                    <div class="row gy-4">

                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.year') }}*</label>
                                <div class="form-control-wrap">
                                    <input class="form-control form_datetime" type="text" placeholder="Year" id="e_year"
                                        name="e_year">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.jan') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_jan" name="e_jan" placeholder="Jan">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.feb') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_feb" name="e_feb" placeholder="Feb">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.mar') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_mar" name="e_mar" placeholder="Mar">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.apr') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_apr" name="e_apr" placeholder="Apr">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.may') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_may" name="e_may" placeholder="May">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.jun') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_jun" name="e_jun" placeholder="Jun">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.jul') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_jul" name="e_jul" placeholder="Jul">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.aug') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_aug" name="e_aug" placeholder="Aug">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.sep') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_sep" name="e_sep" placeholder="Sep">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.oct') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_oct" name="e_oct" placeholder="Oct">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.nov') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_nov" name="e_nov" placeholder="Nov">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">{{ __('locale.dec') }}*</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="e_dec" name="e_dec" placeholder="Dec">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="target_update_btn"><i data-feather="save"></i> {{ __('locale.save') }}</button>
                    <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i> {{ __('locale.cancel') }}</button>
                </div>
            </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous"></script>
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

    $('#search_year').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    $('#a_year').datepicker({
        minViewMode: 'years',
        autoclose: true,
        format: 'yyyy'
    });

    $('#e_year').datepicker({
        minViewMode: 'years',
        autoclose: true,
        format: 'yyyy'
    });


    $('#add_clinic_modal').on('show.bs.modal', function(e) {

        $("#a_year").prop('required', true);
        $("#a_jan").prop('required', true);
        $("#a_feb").prop('required', true);
        $("#a_mar").prop('required', true);
        $("#a_apr").prop('required', true);
        $("#a_may").prop('required', true);
        $("#a_jun").prop('required', true);
        $("#a_jul").prop('required', true);
        $("#a_aug").prop('required', true);
        $("#a_sep").prop('required', true);
        $("#a_oct").prop('required', true);
        $("#a_nov").prop('required', true);
        $("#a_dec").prop('required', true);


        $("#e_year").prop('required', false);
        $("#e_jan").prop('required', false);
        $("#e_feb").prop('required', false);
        $("#e_mar").prop('required', false);
        $("#e_apr").prop('required', false);
        $("#e_may").prop('required', false);
        $("#e_jun").prop('required', false);
        $("#e_jul").prop('required', false);
        $("#e_aug").prop('required', false);
        $("#e_sep").prop('required', false);
        $("#e_oct").prop('required', false);
        $("#e_nov").prop('required', false);
        $("#e_dec").prop('required', false);
    });



    $('#edit_clinic_modal').on('show.bs.modal', function(e) {

        $("#a_year").prop('required', false);
        $("#a_jan").prop('required', false);
        $("#a_feb").prop('required', false);
        $("#a_mar").prop('required', false);
        $("#a_apr").prop('required', false);
        $("#a_may").prop('required', false);
        $("#a_jun").prop('required', false);
        $("#a_jul").prop('required', false);
        $("#a_aug").prop('required', false);
        $("#a_sep").prop('required', false);
        $("#a_oct").prop('required', false);
        $("#a_nov").prop('required', false);
        $("#a_dec").prop('required', false);

        $("#e_year").prop('required', true);
        $("#e_jan").prop('required', true);
        $("#e_feb").prop('required', true);
        $("#e_mar").prop('required', true);
        $("#e_apr").prop('required', true);
        $("#e_may").prop('required', true);
        $("#e_jun").prop('required', true);
        $("#e_jul").prop('required', true);
        $("#e_aug").prop('required', true);
        $("#e_sep").prop('required', true);
        $("#e_oct").prop('required', true);
        $("#e_nov").prop('required', true);
        $("#e_dec").prop('required', true);


        var target_data = $(e.relatedTarget).data('id');
        $("#e_clinic_id").val(target_data['id']);
        $("#e_year").val(target_data['year']);
        $("#e_jan").val(target_data['jan']);
        $("#e_feb").val(target_data['feb']);
        $("#e_mar").val(target_data['mar']);
        $("#e_apr").val(target_data['apr']);
        $("#e_may").val(target_data['may']);
        $("#e_jun").val(target_data['jun']);
        $("#e_jul").val(target_data['jul']);
        $("#e_aug").val(target_data['aug']);
        $("#e_sep").val(target_data['sep']);
        $("#e_oct").val(target_data['oct']);
        $("#e_nov").val(target_data['nov']);
        $("#e_dec").val(target_data['dec']);


    });

    $("#target_update_btn").click(function(e) {
        //        e.preventDefault();
        // document.getElementById("edit_frm").submit();
        //      $("#edit_frm").submit()
    });



});

function delete_func(val) {
    document.getElementById(val).submit();
}
</script>
@endsection