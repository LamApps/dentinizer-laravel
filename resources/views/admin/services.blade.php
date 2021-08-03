@extends('layouts/layoutMaster')

@section('title', 'Services List')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('new-assets/js/jcarousel/custom_jcarousel.css') }}">

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
<!-- Employee Task Card -->
<div class="col-md-12">
        <div class="card card-employee-task">
            <div class="card-header">
                <h4 class="card-title">{{ __('locale.categories') }}</h4>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle hide-arrow mr-1" id="todoActions"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-vertical" class="font-medium-2 text-body"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="todoActions">
                        <a class="dropdown-item sort-asc" href="javascript:void(0)" onclick="_formCategory(0)"><i data-feather="plus"></i> New</a>
                        <a class="dropdown-item sort-asc" href="javascript:void(0)" onclick="_loadCategories()"><i data-feather="refresh-ccw"></i> Reload</a>
                    </div>
                </div>
            </div>
            <div class="card-body" id="BLOCK_CATEGORIES">
                
            </div>
        </div>
    </div>
    <!--/ Employee Task Card -->
</div>

<div class="row match-height">
    <div class="col-md-12">
        <!-- begin card -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('locale.services') }} <span id="spinner_reload_services"></span></h4>
                <!-- <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle hide-arrow mr-1" id="todoActions"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-vertical" class="font-medium-2 text-body"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="todoActions">
                        <a class="dropdown-item sort-asc" href="javascript:void(0)" onclick="_formService(0)"><i data-feather="plus"></i> New</a>
                        <a class="dropdown-item sort-asc" href="javascript:void(0)" onclick="_reload_services_datatable()"><i data-feather="refresh-ccw"></i> Reload</a>
                    </div>
                </div> -->
                <button style="float:right;" type="button" data-toggle="tooltip" data-placement="top" title="Add new service" onclick="_formService(0)" class="btn btn-icon btn-outline-primary btn-sm mr-1"><i data-feather="plus"></i></button>
                <button style="float:right;" type="button" data-toggle="tooltip" data-placement="top" title="Reload" onclick="_reload_services_datatable()" class="btn btn-icon btn-outline-primary btn-sm mr-1"><i data-feather="refresh-ccw"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="services_datatable">
                        <thead>
                            <tr>
                                <th>{{ __('locale.code') }}</th>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.price') }} ({{__('locale.'.env('CURRENCY_SYMBOL')) }})</th>
                                <th>{{ __('locale.category') }}</th>
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
        <!-- begin card -->
    </div>
</div>

<x-modal-form id="modal_form_category" formName="CATEGORY" content="modal_form_category_content" />
<x-modal-form id="modal_form_service" formName="SERVICE" content="modal_form_service_content" />
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

<script src="{{ asset('new-assets/js/jcarousel/jcarousel.min.js') }}"></script>

@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
//load categories
_loadCategories();
/* nOTES */
var dtUrl = '/admin/sdt/services/0';
var services_datatable = $('#services_datatable');
services_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
    language: {
            url: '/json/datatable/ar.json'
    },
    @endif
    processing: true,
    paging: true,
    ordering: true,
    ajax: {
        url: dtUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
});
var _reload_services_datatable = function() {
    $('#services_datatable').DataTable().ajax.reload();
}
function _formService(service_id) {
    var modal_id = "modal_form_service";
    var modal_content_id = "modal_form_service_content";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (service_id > 0)? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#SERVICE_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT ')!!} ' + modalTitle);
    $.ajax({
        url: "/admin/form/service/" + service_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
            var idCategorie = $("#categorie_id_hidden").val();
            _loadDatasCategoriesForSelectOptions('categoriesSelect',idCategorie);
        },
    });
};
function _loadDatasCategoriesForSelectOptions(select_id,selected_value = 0) { 
    $.ajax({
        url: '/admin/select/json/categories',
        dataType: 'json',
        success: function(response) {
          var array = response;
          if (array != '')
          {
            for (i in array) {                        
             $('#'+select_id).append("<option value='"+array[i].id+"'>"+array[i].name+"</option>");
           }
          }
        },
    }).done(function() {
        if(selected_value!=0 && selected_value!=''){
            $('#'+select_id+' option[value="'+selected_value+'"]').attr('selected', 'selected');
        }
      });
}

$("#FORM_SERVICE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_SERVICE").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/service",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_service").modal("hide");
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
                $("#SPAN_SAVE_SERVICE").removeClass("spinner-border spinner-border-sm");
                _reload_services_datatable();
            },
        });
        return false;
    },
});

function _deleteService(id) {
    var successMsg = "Your service has been deleted.";
    var errorMsg = "Your service has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete?";
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
                url: "/admin/delete/service/" + id,
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
                    _reload_services_datatable();
                },
            });
        }
    });
}

function _loadCategories(){
    var spinner ='<div class="spinner-border text-primary text-center"><span class="sr-only">Loading...</span></div>';
    $("#BLOCK_CATEGORIES").html(spinner);
    $.ajax({
        url: "/admin/category/list",
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#BLOCK_CATEGORIES").html(html);
        },
    });
}

function _loadDatasByCategory(category_id){
    var spinner ='<div class="spinner-border text-primary text-center"><span class="sr-only">Loading...</span></div>';
    $('#spinner_reload_services').html(spinner);
    var table = 'services_datatable';
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '/admin/sdt/services/'+category_id,
        success: function(response) {
            $('#spinner_reload_services').html('');
            if (response.data.length == 0) {
                $('#'+table).dataTable().fnClearTable();
                return 0;
            }
            $('#'+table).dataTable().fnClearTable();
            $("#"+table).dataTable().fnAddData(response.data, true);
        },
        error: function() {
            $('#'+table).dataTable().fnClearTable();
        }
    }).done(function(data) {
        
    });
}
function _formCategory(category_id) {
    var modal_id = "modal_form_category";
    var modal_content_id = "modal_form_category_content";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (category_id > 0)? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#CATEGORY_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT ')!!} ' + modalTitle);
    $.ajax({
        url: "/admin/form/category/" + category_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

$("#FORM_CATEGORY").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_CATEGORY").addClass("spinner-border spinner-border-sm");
        //var formData = $(form).serializeArray(); // convert form to array
        var formData = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            url: "/admin/form/category",
            data: formData,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_category").modal("hide");
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
                $("#SPAN_SAVE_CATEGORY").removeClass("spinner-border spinner-border-sm");
                _loadCategories();
            },
        });
        return false;
    },
});

function _deleteCategory(id) {
    var successMsg = "Your category has been deleted.";
    var errorMsg = "Your category has not been deleted.";
    var swalConfirmTitle = "Are you sure you want to delete?";
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
                url: "/admin/delete/category/" + id,
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
                    _loadCategories();
                },
            });
        }
    });
}
</script>
@endsection