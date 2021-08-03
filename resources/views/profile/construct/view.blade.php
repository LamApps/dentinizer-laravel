<input type="hidden" id="VIEW_INPUT_PATIENT_ID" value="{{ $patient_id }}">
@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

@if($viewtype=='overview')
@php
$birthday = '';
if($patient){
if(isset($patient->birthday)){
$dt = Carbon\Carbon::createFromFormat('Y-m-d',$patient->birthday);
$birthday = $dt->format('d/m/Y');  
}    

}

$patient_status='Open';
$patient_status_css_class='warning';
if($patient->state == 0){
$patient_status='Open';
$patient_status_css_class='success';
}elseif($patient->state == 1){
$patient_status='Complete';
$patient_status_css_class='warning';
}

@endphp


<!-- statistics billing-->
<div class="card card-statistics shadow-none bg-transparent border-primary">
    <div class="card-body statistics-body">
        <h4 class="card-title">{{ __('locale.statistics') }}</h4>
        <div class="row mb-2">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-primary mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('CALENDAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="nb_appointments">0</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.appointments') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-success mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('MIC')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="nb_notes">0</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.notes') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-warning mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('ARCHIVE')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="nb_storages">0</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.storage') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-info mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('TRENDING')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="nb_invoices">0</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.invoices') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-info mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_invoices">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.total') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                <div class="media">
                    <div class="avatar bg-light-danger mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_paid_invoices">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.paid') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="media">
                    <div class="avatar bg-light-success mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_discount">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.discount') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- statistics -->
<div class="card card-statistics shadow-none bg-transparent border-primary">
    <div class="card-body statistics-body">
        <h4 class="card-title">{{ __('locale.about') }}</h4>
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-2">
                    <h6 class="mb-75">{{ __('locale.birthday') }}:</h5>
                        <p class="card-text">{{$birthday}}</p>
                </div>
                <div class="mt-2">
                    <h6 class="mb-75">{{ __('locale.phone') }}:</h5>
                        <p class="card-text">{{ $patient->phone }}</p>
                </div>
                <div class="mt-2">
                    <h6 class="mb-75">{{ __('locale.email') }}:</h5>
                        <p class="card-text">{{ $patient->email }}</p>
                </div>
                <div class="mt-2">
                    <h6 class="mb-50">{{ __('locale.newress') }}:</h5>
                        <p class="card-text mb-0">{{ $patient->address }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <h6 class="mb-75">{{ __('locale.status') }}:</h5>
                        <p class="card-text"><span
                                class="badge badge-light-{{$patient_status_css_class}}">{{$patient_status}}</span></p>
                </div>
                <div class="mt-2">
                    <h6 class="mb-50">{{ __('locale.created_at') }}:</h5>
                        <p class="card-text mb-0"><span
                                class="badge badge-light-primary">{{ ($patient->created_at)?$patient->created_at->format('Y/m/d H:i'):'' }}</span>
                        </p>
                </div>
                <div class="mt-2">
                    <h6 class="mb-50">{{ __('locale.updated_at') }}:</h5>
                        <p class="card-text mb-0"><span
                                class="badge badge-light-info">{{ ($patient->updated_at)?$patient->updated_at->format('Y/m/d H:i'):''}}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
_loadPatientStats();

function _loadPatientStats() {
    var spinner = '<span class="spinner-border spinner-border-sm"></span>';
    $("#nb_invoices,#total_invoices,#total_paid_invoices,#total_discount").html(spinner);
    var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
    $.ajax({
        url: "/profile/stats/invoice/" + patient_id,
        type: "GET",
        dataType: "json",
        success: function(res, status) {
            $("#nb_invoices").html(res.nb_invoices);
            $("#total_invoices").html(res.total_invoices + ' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
            $("#total_paid_invoices").html(res.total_paid_invoices + ' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
            $("#total_discount").html(res.total_discount+ ' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
            //stats
            $("#nb_appointments").html(res.nb_appointments);
            $("#nb_notes").html(res.nb_notes);
            $("#nb_storages").html(res.nb_storages);
        },
    });
};
</script>
@endif

@if($viewtype=='procedures')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-none bg-transparent border-primary">
            <div class="card-body">
                <!-- carousel -->
                <div class="jcarousel-wrapper p-1">
                    <div id="jcarousel-categories" class="jcarousel">
                        <ul>
                            @if(count($categories) > 0 )
                            @foreach($categories as $k=>$category)
                            <li class="text-center">
                                <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons"> -->
                                    <label style="border:0 !important;" class="btn btn-outline-primary btn-sm mb-1">
                                        @if($category->path_icon)
                                        <p class="mb-0 text-center"><img style="height:30px"
                                                src="{{asset(base64_decode($category->path_icon))}}" class="" /></p>
                                        @endif
                                        <input type="radio" name="radio_categories" value="{{$category->id}}"
                                            id="radio_category{{$category->id}}" {{ ($k==0)?'checked':'' }} />
                                        {{$category->name}}
                                    </label>
                                <!-- </div> -->
                            </li>
                            @endforeach
                            @else
                            <li>No categories</li>
                            @endif
                        </ul>
                    </div>

                    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                    <a href="#" class="jcarousel-control-next">&rsaquo;</a>

                    <p class="jcarousel-pagination d-none"></p>
                </div>
                <!-- carousel -->

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <!-- Procedures-->
        <div class="card shadow-none bg-transparent border-primary">
            <div class="card-body" id="BLOCK_TOOTHS_PROCEDURES"></div>
        </div>
        <!-- Procedures -->
    </div>
    <div class="col-md-12">
        <!-- services-->
        <div class="card shadow-none bg-transparent border-primary">
            <div class="card-body">

                <!-- <div class="card shadow-none bg-transparent border-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"><p class="mt-0 mb-0">Select doctor to show or download pdf:</p></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control form-control-sm js-select2" id="select_list_doctors">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-primary" onclick="_pdf(1)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('FILE')!!} Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-warning" onclick="_pdf(2)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                @if(Auth::user()->user_type == "doctor")
                <div class="card shadow-none bg-transparent border-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-primary" onclick="_printPdf(0,1)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('FILE')!!} Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-warning" onclick="_printPdf(0,2)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="procedures_datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkbox checkbox-single">
                                        <input type="checkbox" value="" class="group-checkable"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th>{{ __('locale.teeth') }}</th>
                                <th>{{ __('locale.service') }}</th>
                                <th>{{ __('locale.quantity') }}</th>
                                <th>{{ __('locale.rate') }}</th>
                                <th>{{ __('locale.total') }}</th>
                                <th>{{ __('locale.note') }}</th>
                                <th>{{ __('locale.actions') }}</th>
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
<script>
$(document).ready(function() {
    $('.js-select2').select2();
});
//init
doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
_loadDatasDoctorsForSelectOptions('select_list_doctors', doctor_id, 0);
function _pdf(mode){
    mode=(mode==1)?'stream':'download';
    var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
    var doctor_id = $('#select_list_doctors').val();
    if(doctor_id<1){
        _showResponseMessage("error", 'Please select doctor');
        return false;
    }
    $link="/procedures/pdf/"+doctor_id+"/"+patient_id+"/0/"+mode;
    //window.location.href = $link;
    window.open($link, '_blank');
}
(function($) {
    $(function() {
        var jcarousel = $('#jcarousel-categories');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function() {
                var carousel = $(this),
                    width = carousel.innerWidth();

                if (width >= 600) {
                    width = width / 6;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular',
                @if($lang=='ar')
                rtl: true,
                @endif
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });
    });
})(jQuery);

var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
//procedures_datatable
var dtProceduresUrl = '/admin/sdt/procedures/' + patient_id;
var procedures_datatable = $('#procedures_datatable');
procedures_datatable.DataTable({
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
        url: dtProceduresUrl,
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

procedures_datatable.on('change', '.group-checkable', function() {
    var set = $(this).closest('table').find('td:first-child .checkable');
    var checked = $(this).is(':checked');

    $(set).each(function() {
        if (checked) {
            $(this).prop('checked', true);
            $(this).closest('tr').addClass('active');
        } else {
            $(this).prop('checked', false);
            $(this).closest('tr').removeClass('active');
        }
    });
});

procedures_datatable.on('change', 'tbody tr .checkbox', function() {
    $(this).parents('tr').toggleClass('active');
});


var _reload_procedures_datatable = function() {
    $('#procedures_datatable').DataTable().ajax.reload();
}

function _printPdf(id,mode){
		var TableauIdProcess = new Array();
		var j = 0;
		if(id>0){
			TableauIdProcess[0]=id;
		}else{	
            $('#procedures_datatable input[class="checkable"]').each(function(){
   			    var checked = jQuery(this).is(":checked");
                if(checked){
                    TableauIdProcess[j] = jQuery(this).val();
                    j++;
                }
   			});
		}
    	if(TableauIdProcess.length<1){
    		//alert('Please select service');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select service!',
            })
    	}else{
            mode=(mode==1)?'stream':'download';
            var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
            var doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
            //var doctor_id = 13;
            $link="/procedures/pdf/"+doctor_id+"/"+patient_id+"/0/"+mode;


            var procedure_service_item_ids = JSON.stringify(TableauIdProcess);

            const encodedData = window.btoa(procedure_service_item_ids);
            //console.log(myJsonString);
            $link="/procedures/pdf/"+doctor_id+"/"+patient_id+"/"+encodedData+"/"+mode;
            window.open($link, '_blank');	
    	}
}

function _formProcedureServiceItem(procedure_service_item_id, teeth_id) {

    var patient_id = $("#INPUT_HIDDEN_PATIENT_ID").val();
    var doctor_id = 0;

    var modal_id = "modal_form_procedure_service_item";
    var modal_content_id = "modal_form_procedure_service_item_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = ((procedure_service_item_id > 0) ? 'Edit item' : 'New item') + ' : Selected teeth - ' + teeth_id;
    $("#ITEM_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('
        EDIT ')!!} ' + modalTitle);
    $.ajax({
        url: "/admin/form/procedure/service/item/" + procedure_service_item_id + "/" + teeth_id + "/" +
            patient_id + "/" + doctor_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
            category_id = $('input[name=radio_categories]:checked').val();
            doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
            _loadDatasServicesForSelectOptions('select_services', category_id, 0);
            _loadDatasDoctorsForSelectOptions('select_doctors', doctor_id, 0);
        },
    });
};
$("#FORM_ITEM").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_ITEM").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/procedure/service/item",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_procedure_service_item").modal("hide");
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
                $("#SPAN_SAVE_ITEM").removeClass("spinner-border spinner-border-sm");
                _reload_procedures_datatable();
            },
        });
        return false;
    },
});

function calculateTotalPriceService(service_id) {
    if (service_id > 0) {
        $.ajax({
            url: '/admin/get/price/service/' + service_id,
            dataType: 'json',
            success: function(response) {
                quantity = $('#quantity').val();
                var rate = response.price;
                $('#rate').val(rate);
                var total = quantity * rate;
                $('#total').val(total);
            },
        }).done(function() {});
    }
}

function onChangeQuantity() {
    quantity = $('#quantity').val();
    var rate = $('#rate').val();
    var total = quantity * rate;
    $('#total').val(total);
}

function _loadDatasServicesForSelectOptions(select_id, category_id, selected_value = 0) {
    $.ajax({
        url: '/admin/select/json/services/' + category_id,
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
    }).done(function() {
        if (selected_value != 0 && selected_value != '') {
            $('#' + select_id + ' option[value="' + selected_value + '"]').attr('selected', 'selected');
        }
        var service_id = $('#select_services').val();
        calculateTotalPriceService(service_id);
    });
}

function _loadDatasDoctorsForSelectOptions(select_id, doctor_id, selected_value = 0) {
    $.ajax({
        url: '/admin/select/json/doctors/' + doctor_id,
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
    }).done(function() {
        if (selected_value != 0 && selected_value != '') {
            $('#' + select_id + ' option[value="' + selected_value + '"]').attr('selected', 'selected');
        }
    });
}

_loadProceduresTooths();

function _loadProceduresTooths() {
    var spinner =
        '<center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center>';
    $('#BLOCK_TOOTHS_PROCEDURES').html(spinner);
    $.ajax({
        url: "/profile/get/procedures/tooths",
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $('#BLOCK_TOOTHS_PROCEDURES').html(html);
        },
    });
}


function _deleteProcedureServiceItem(id) {
    var successMsg = "Procedure service has been deleted.";
    var errorMsg = "Procedure service has not been deleted.";
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
                url: "/admin/delete/procedure/service/item/" + id,
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
                    _reload_procedures_datatable();
                },
            });
        }
    });
}

</script>
@endif
@if($viewtype=='notes')
<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-10"></div>
            <div class="col-md-2 text-right">
                <button onclick="_formNote({{ $patient_id }},0)"
                    class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
            </div>
        </div>
        <!-- Notes -->
        <div class="table-responsive">
            <table id="notes_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('locale.id') }}</th>
                        <th>{{ __('locale.by') }}</th>
                        <th>{{ __('locale.description') }}</th>
                        <th>{{ __('locale.attachment') }}</th>
                        <th>{{ __('locale.created_at') }}</th>
                        <th>{{ __('locale.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- Notes -->
    </div>
</div>
<script>
var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
/* nOTES */
var dtUrl = '/profile/sdt/notes/' + patient_id;
var notes_datatable = $('#notes_datatable');
notes_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
    @endif
    processing: true,
    paging: true,
    ordering: false,
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
var _reload_notes_datatable = function() {
    $('#notes_datatable').DataTable().ajax.reload();
}

function _formNote(patient_id, note_id) {
    var modal_id = "modal_form_note";
    var modal_content_id = "modal_form_note_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (note_id > 0) ? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#NOTE_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} ' + modalTitle);
    $.ajax({
        url: "/profile/form/note/" + patient_id + '/' + note_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};

function _reset_note_form() {
    var modal_content_id = "modal_form_note_body";
    stopRecording();
    $("#" + modal_content_id).html('<p></p>');
}

$("#FORM_NOTE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        var formDataToUpload = new FormData(form);
        $("#SPAN_SAVE").addClass("spinner-border spinner-border-sm");
        var fileUrl = $('#BLOB_FILE').val();
        if (fileUrl != '') {
            var block = fileUrl.split(";");
            // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif"
            // get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            var filename = Math.floor(Date.now() / 1000);
            formDataToUpload.append("audio_data", blob, filename + ".wav");
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: formDataToUpload,
            url: '/profile/form/note',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("#modal_form_note").modal('hide');
                    _showResponseMessage("success", response.msg);
                    _reload_notes_datatable();
                    $("#SPAN_SAVE").removeClass("spinner-border spinner-border-sm");
                    _loadContent('notes');
                } else {
                    _showResponseMessage("error", response.msg);
                }
            },
            error: function() {}
        }).done(function(data) {});
        return false;
    },
});

function _submit_note_form() {
    var fileUrl = $('#BLOB_FILE').val();
    if (fileUrl != '') {
        $("#SUBMIT_NOTE_FORM").click();
    } else {
        /* $.ajax({
            url: stopRecording(),
            success: function() {
                $("#SUBMIT_NOTE_FORM").click();
            }
        }); */
        $("#SUBMIT_NOTE_FORM").click();
    }
}

function _deleteNote(id) {
    var successMsg = "Your note has been deleted.";
    var errorMsg = "Your note has not been deleted.";
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
                url: "/profile/delete/note/" + id,
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
                    _reload_notes_datatable();
                },
            });
        }
    });
}

function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {
        type: contentType
    });
    return blob;
}
</script>
@endif
@if($viewtype=='billings')

<!-- statistics -->
<div class="card card-statistics shadow-none bg-transparent border-primary">
    <div class="card-body statistics-body">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-primary mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('TRENDING')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="nb_invoices">0</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.invoices') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="media">
                    <div class="avatar bg-light-info mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_invoices">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.total') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                <div class="media">
                    <div class="avatar bg-light-danger mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_paid_invoices">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.paid') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="media">
                    <div class="avatar bg-light-success mr-2">
                        <div class="avatar-content">
                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOLLAR')!!}
                        </div>
                    </div>
                    <div class="media-body my-auto">
                        <h4 class="font-weight-bolder mb-0" id="total_discount">0 {{__('locale.'.env('CURRENCY_SYMBOL')) }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ __('locale.discount') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- statistics -->
<!-- invoices -->
<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-10">
                <h4>{{ __('locale.invoices') }}</h4>
            </div>
            <div class="col-md-2 text-right">
                <button onclick="_formInvoice({{ $patient_id }},0)"
                    class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
                
            </div>
        </div>

        <div class="card shadow-none bg-transparent border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-primary" onclick="_printPdfInvoices(0,1)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('FILE')!!} Export Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-warning" onclick="_printPdfInvoices(0,2)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Download Pdf</button>
                                    <button type="button" class="btn btn-icon btn-sm btn-outline-success" onclick="_printPdfInvoices(0,3)">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('DOWNLOAD')!!} Export Excel</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button style="float:right;" onclick="_formQuickInvoice({{ $patient_id }})" class="btn btn-sm btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!} Quick invoice</button>
                            </div>
                        </div>
                    </div>
                </div>

        <div class="table-responsive">
            <table id="invoices_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <label class="checkbox checkbox-single"><input type="checkbox" value="" class="group-checkable"/><span></span></label>
                        </th>
                        <th>{{ __('locale.code') }}</th>
                        <th>{{ __('locale.infos') }}</th>
                        <th>{{ __('locale.total') }}</th>
                        <th>{{ __('locale.paid') }}</th>
                        <th>{{ __('locale.status') }}</th>
                        <th>{{ __('locale.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- invoices -->
<script>
var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
/* nOTES */
var dtUrl = '/profile/sdt/invoices/' + patient_id;
var invoices_datatable = $('#invoices_datatable');
invoices_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
    @endif
    processing: true,
    paging: true,
    ordering: false,
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

invoices_datatable.on('change', '.group-checkable', function() {
    var set = $(this).closest('table').find('td:first-child .checkable');
    var checked = $(this).is(':checked');

    $(set).each(function() {
        if (checked) {
            $(this).prop('checked', true);
            $(this).closest('tr').addClass('active');
        } else {
            $(this).prop('checked', false);
            $(this).closest('tr').removeClass('active');
        }
    });
});

invoices_datatable.on('change', 'tbody tr .checkbox', function() {
    $(this).parents('tr').toggleClass('active');
});

var _reload_invoices_datatable = function() {
    $('#invoices_datatable').DataTable().ajax.reload();
}

function _formInvoice(patient_id, invoice_id) {
    var modal_id = "modal_form_invoice";
    var modal_content_id = "modal_form_invoice_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (invoice_id > 0) ? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#INVOICE_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/profile/form/invoice/" + patient_id + '/' + invoice_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
            //if user doctor
            doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
            _loadDatasDoctorsForSelectOptions('select_doctors_invoice', doctor_id, doctor_id);
        },
    });
};

$("#FORM_INVOICE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_INVOICE").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/profile/form/invoice",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    //$("#modal_form_invoice").modal("hide");
                    var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
                    _formInvoice(patient_id, result.invoice_id);
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
                $("#SPAN_SAVE_INVOICE").removeClass("spinner-border spinner-border-sm");
                _reload_invoices_datatable();
                _loadBillingStats();
            },
        });
        return false;
    },
});

function _loadDatasDoctorsForSelectOptions(select_id, doctor_id, selected_value = 0) {
    $.ajax({
        url: '/admin/select/json/doctors/' + doctor_id,
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
    }).done(function() {
        if (selected_value != 0 && selected_value != '') {
            $('#' + select_id + ' option[value="' + selected_value + '"]').attr('selected', 'selected');
        }
    });
}

function _formPayment(payment_id, invoice_id) {
    var modal_id = "modal_form_payment";
    var modal_content_id = "modal_form_payment_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (payment_id > 0) ? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#PAYMENT_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/profile/form/payment/" + payment_id + '/' + invoice_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};
$("#FORM_PAYMENT").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_PAYMENT").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/profile/form/payment",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_payment").modal("hide");
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
                $("#SPAN_SAVE_PAYMENT").removeClass("spinner-border spinner-border-sm");
                _reload_invoices_datatable();
            },
        });
        return false;
    },
});

_loadBillingStats();
function _loadBillingStats() {
    var spinner = '<span class="spinner-border spinner-border-sm"></span>';
    $("#nb_invoices,#total_invoices,#total_paid_invoices,#total_discount").html(spinner);
    var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
    $.ajax({
        url: "/profile/stats/invoice/" + patient_id,
        type: "GET",
        dataType: "json",
        success: function(res, status) {
            $("#nb_invoices").html(res.nb_invoices);
            $("#total_invoices").html(res.total_invoices+' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
            $("#total_paid_invoices").html(res.total_paid_invoices+' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
            $("#total_discount").html(res.total_discount+' {{__('locale.'.env('CURRENCY_SYMBOL')) }}');
        },
    });
};


function _formRefund(refund_id, invoice_id) {
    var modal_id = "modal_form_refund";
    var modal_content_id = "modal_form_refund_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (refund_id > 0) ? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#REFUND_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/profile/form/refund/" + refund_id + '/' + invoice_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};
$("#FORM_REFUND").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_REFUND").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/profile/form/refund",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_refund").modal("hide");
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
                $("#SPAN_SAVE_REFUND").removeClass("spinner-border spinner-border-sm");
                _reload_invoices_datatable();
            },
        });
        return false;
    },
});
function _printPdfInvoices(id,mode){
		var TableauIdProcess = new Array();
		var j = 0;
		if(id>0){
			TableauIdProcess[0]=id;
		}else{	
            $('#invoices_datatable input[class="checkable"]').each(function(){
   			    var checked = jQuery(this).is(":checked");
                if(checked){
                    TableauIdProcess[j] = jQuery(this).val();
                    j++;
                }
   			});
		}
    	if(TableauIdProcess.length<1){
    		//alert('Please select service');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select service!',
            })
    	}else{
            var invoices_ids = JSON.stringify(TableauIdProcess);
            const encodedData = window.btoa(invoices_ids);
            if(mode==3){
                link="/invoices/xls/"+encodedData;
                window.open(link, '_blank');
            }
            mode=(mode==1)?'stream':'download';
            var patient_id = $('#VIEW_INPUT_PATIENT_ID').val();
            //var doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
            $link="/invoices/pdf/"+patient_id+"/"+encodedData+"/"+mode;
            window.open($link, '_blank');	
    	}
}

function _formQuickInvoice(patient_id) {
    var modal_id = "modal_form_quick_invoice";
    var modal_content_id = "modal_form_quick_invoice_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = "{{ __('locale.new') }}";
    $("#QUICK_INVOICE_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/profile/form/quick/invoice/" + patient_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
            //if user doctor
            doctor_id = {{(Auth::user()->user_type == "doctor")?Auth::user()->id:0}};
            _loadDatasDoctorsForSelectOptions('select_doctors_quick_invoice', doctor_id, doctor_id);
        },
    });
};
$("#FORM_QUICK_INVOICE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_QUICK_INVOICE").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/profile/form/quick/invoice",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_quick_invoice").modal("hide");
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
                $("#SPAN_SAVE_QUICK_INVOICE").removeClass("spinner-border spinner-border-sm");
                _reload_invoices_datatable();
                //_loadBillingStats();
            },
        });
        return false;
    },
});
</script>
@endif
@if($viewtype=='storages')
<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
        <!-- <p>Storage</p> -->
        <div class="row mb-2">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <button class="btn btn-icon btn-outline-primary" data-toggle="modal"
                    data-target="#modal_form_storage">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="storage_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('locale.id') }}</th>
                        <th>{{ __('locale.by') }}</th>
                        <th>{{ __('locale.title') }}</th>
                        <th>{{ __('locale.description') }}</th>
                        <th>{{ __('locale.attachment') }}</th>
                        <th>{{ __('locale.created_at') }}</th>
                        <th>{{ __('locale.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function setup_camera() {
    $('#data_uri_hidden').val('');
    Webcam.reset();
    Webcam.attach('#BLOCK_CAMERA');
    hide_upload_file();
}

function take_photo() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
        // display results in page
        $('#results').html('<img class="img-fluid" src="' + data_uri + '"/>');
        $('#data_uri_hidden').val(data_uri);
    });
}

function show_upload_file() {
    Webcam.reset('#BLOCK_CAMERA');
    $("#BLOCK_CAMERA").removeAttr("style");
    $('#data_uri_hidden').val('');
    $('#BLOCK_UPLOAD_FILE').html('<input type="file" class="form-control-file" name="file" id="file" required />');
}

function hide_upload_file() {
    $('#BLOCK_UPLOAD_FILE').html('');
}
/* storageS */
var dtStorageUrl = '/profile/sdt/storages/{{ $patient_id }}';
var storage_datatable = $('#storage_datatable');
storage_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
    @endif
    processing: true,
    paging: true,
    ordering: false,
    ajax: {
        url: dtStorageUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
    drawCallback: function(settings) {
        $("a.fancybox-file").fancybox();
    },
});
var _reload_storages_datatable = function() {
    $('#storage_datatable').DataTable().ajax.reload();
}
/* Storage form */
$("#FORM_STORAGE").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {

        $("#SPAN_SAVE_STORAGE").addClass("spinner-border spinner-border-sm");
        var fileUrl = $('#data_uri_hidden').val();
        if (fileUrl != '') {
            var formData = new FormData(form);
            var block = fileUrl.split(";");
            // Get the content type of the image
            var contentType = block[0].split(":")[1]; // In this case "image/gif"
            // get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "R0lGODlhPQBEAPeoAJosM...."
            // Convert it to a blob to upload
            var blob = b64toBlob(realData, contentType);
            var filename = Math.floor(Date.now() / 1000);
            formData.append("file", blob, filename + ".jpeg");
        } else {
            var formData = new FormData($(form)[0]);
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: formData,
            url: '/profile/form/storage',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("#modal_form_storage").modal('hide');
                    _showResponseMessage("success", response.msg);
                    _reload_storages_datatable();
                    $("#SPAN_SAVE_STORAGE").removeClass("spinner-border spinner-border-sm");
                } else {
                    _showResponseMessage("error", response.msg);
                }
            },
            error: function() {}
        }).done(function(data) {});
        return false;
    },
});

function _deletePatientStorage(id) {
    var successMsg = "Your file has been deleted.";
    var errorMsg = "Your file has not been deleted.";
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
                url: "/profile/delete/storage/" + id,
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
                    _reload_storages_datatable();
                },
            });
        }
    });
}
navigator.getMedia = (navigator.getUserMedia || // use the proper vendor prefix
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

navigator.getMedia({
    video: true
}, function() {
    // webcam is available
    console.log('webcam is available');
}, function() {
    // webcam is not available
    console.log('webcam is not available');
});
Webcam.set({
    width: 768,
    height: 576,
    image_format: 'jpeg',
    //jpeg_quality: 90
});
</script>
@endif
@if($viewtype=='xray')
<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
        <!-- <p>Storage</p> -->
        <div class="row mb-2">
            <div class="col-md-10">
            </div>
            <div class="col-md-2 text-right">
                <button class="btn btn-icon btn-outline-primary" data-toggle="modal"
                    data-target="#modal_form_xray">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="xray_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('locale.id') }}</th>
                        <th>{{ __('locale.by') }}</th>
                        <th>{{ __('locale.title') }}</th>
                        <th>{{ __('locale.description') }}</th>
                        <th>{{ __('locale.attachment') }}</th>
                        <th>{{ __('locale.created_at') }}</th>
                        <th>{{ __('locale.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
/* xray */
var dtStorageUrl = '/profile/sdt/xray/{{ $patient_id }}';
var xray_datatable = $('#xray_datatable');
xray_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
    @endif
    processing: true,
    paging: true,
    ordering: false,
    ajax: {
        url: dtStorageUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
    drawCallback: function(settings) {
        $("a.fancybox-file").fancybox();
    },
});
function _reload_xray_datatable() {
    $('#xray_datatable').DataTable().ajax.reload();
}
/* Storage form */
$("#FORM_XRAY").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_XRAY").addClass("spinner-border spinner-border-sm");
        var formData = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: formData,
            url: '/profile/form/xray',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("#modal_form_xray").modal('hide');
                    _showResponseMessage("success", response.msg);
                    _reload_xray_datatable();
                    $("#SPAN_SAVE_XRAY").removeClass("spinner-border spinner-border-sm");
                } else {
                    _showResponseMessage("error", response.msg);
                }
            },
            error: function() {}
        }).done(function(data) {});
        return false;
    },
});

function _deleteXray(id) {
    var successMsg = "Your file has been deleted.";
    var errorMsg = "Your file has not been deleted.";
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
                url: "/profile/delete/xray/" + id,
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
                    _reload_xray_datatable();
                },
            });
        }
    });
}
</script>
@endif