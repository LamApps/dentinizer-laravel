{{ csrf_field() }}
<input type="hidden" id="INPUT_HIDDEN_INVOICE_ID" name="id" value="{{ ($invoice)?$invoice->id:0 }}" />
<input type="hidden" name="patient_id" value="{{ ($invoice)?$invoice->patient_id:$patient_id }}" />

<!-- begin::header -->
<div class="row">
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label for="patients">{{ __('locale.patient') }}</label>
                <input type="text" class="form-control form-control-sm" value="{{ ($patient && $patient->ar_name)?$patient->ar_name:$patient->name }}"
                    readonly />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="select_doctors">{{ __('locale.doctor') }}</label>
                @php
                $readonly='';
                if($invoice && $invoice->doctor_id>0){
                    $readonly='readonly';
                }
                if(Auth::user()->user_type == "doctor"){
                    $readonly='readonly';
                }
                @endphp
                <select class="form-control form-control-sm js-select2" id="select_doctors_invoice" name="doctor_id"
                    {{ $readonly }}>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="select-tax">{{ __('locale.tax') }} (%)</label>
                <input type="number" class="form-control form-control-sm" name="tax_percentage"
                    value="{{ ($invoice)?$invoice->tax_percentage:'' }}" placeholder="Enter tax" />
                <!-- <select class="form-control form-control-sm" id="tax_percentage" name="tax_percentage">
                <option value="">No tax</option>
                <option value="5">5 %</option>
                <option value="10">10 %</option>
                <option value="20">20 %</option>
            </select> -->
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('locale.invoice') }}</label>
                <input type="text" class="form-control form-control-sm" value="{{ ($invoice)?$invoice->number:'' }}"
                    readonly />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                @php
                $dtNow = Carbon\Carbon::now();
                $bill_date =$dtNow->format('Y-m-d');
                if($invoice && $invoice->bill_date!=null){
                $dt = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->bill_date);
                $bill_date = $dt->format('Y-m-d');
                }
                @endphp

                <label for="fp-bill-date">{{ __('locale.bill_date') }}</label>
                <input type="text" id="fp-bill-date" class="form-control flatpickr-basic form-control-sm"
                    name="bill_date" value="{{$bill_date}}" placeholder="YYYY-MM-DD" required />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                @php
                $newDateTime = Carbon\Carbon::now()->addMonth();
                $due_date =$newDateTime->format('Y-m-d');
                if($invoice && $invoice->due_date!=null){
                $dt = Carbon\Carbon::createFromFormat('Y-m-d',$invoice->due_date);
                $due_date = $dt->format('Y-m-d');
                }
                @endphp

                <label for="fp-due-date">{{ __('locale.due_date') }}</label>
                <input type="text" id="fp-due-date" class="form-control flatpickr-basic form-control-sm" name="due_date"
                    value="{{$due_date}}" placeholder="YYYY-MM-DD" required />
            </div>
        </div>
    </div>
</div>
<!-- end::header -->


<div class="row">


</div>
<div class="row">
    <div class="col-md-6">

    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="cf-default-textarea">{{ __('locale.note') }}</label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="5" id="note" name="note"
                    placeholder="Enter Note">{{ ($invoice)?$invoice->note:'' }}</textarea>
            </div>
        </div>
    </div>
</div>



<!-- Items -->
@if($invoice)
<div class="row">
    <div class="col-md-12">
        <button style="float:right;" type="button" class="btn btn-icon btn-sm btn-outline-primary mr-1"
            data-toggle="tooltip" title="Discount"
            onclick="_formDiscount({{$invoice->id}})">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('GIFT')!!}</button>
        <button style="float:right;" type="button" class="btn btn-icon btn-sm btn-outline-primary mr-1"
            data-toggle="tooltip" title="Add service to invoice"
            onclick="_addItemsToInvoice({{$invoice->id}})">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12" id="INVOICE_ITEMS"></div>
</div>
@endif
<!-- Items -->


<script>
$('#fp-bill-date').flatpickr();
$('#fp-due-date').flatpickr();

_loadIvoiceItems();

function _loadIvoiceItems() {
    var invoice_id = $('#INPUT_HIDDEN_INVOICE_ID').val();
    if (invoice_id > 0) {
        $('#INVOICE_ITEMS').html(
            '<div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center>'
        );
        $.ajax({
            url: '/profile/get/invoice/items/' + invoice_id,
            type: 'GET',
            dataType: 'html',
            success: function(html, status) {
                $('#INVOICE_ITEMS').html(html);
            },
            error: function(result, status, error) {},
            complete: function(result, status) {}
        });
    }
}

function _formDiscount(invoice_id) {
    $('#BLOCK_DISCOUNT').html(
        '<div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center>'
    );
    $.ajax({
        url: '/profile/form/discount/' + invoice_id,
        type: 'GET',
        dataType: 'html',
        success: function(html, status) {
            $('#BLOCK_DISCOUNT').html(html);
        },
        error: function(result, status, error) {},
        complete: function(result, status) {}
    });
}
function annulateDiscount(){
    $('#BLOCK_DISCOUNT').html('');
}
//modal_add_items_to_invoice
function _addItemsToInvoice(invoice_id) {
    var modal_id = "modal_add_items_to_invoice";
    var modal_content_id = "modal_add_items_to_invoice_content";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = "{{__('locale.add_services_to_current_invoice')}}";
    $("#INVOICE_ITEMS_MODAL_TITLE").html(modalTitle);
    $.ajax({
        url: "/profile/invoice/items/" + invoice_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};
$("#FORM_INVOICE_ITEMS").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        _showLoader('BTN_SAVE_INVOICE_ITEMS');
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: 'POST',
            url: '/profile/invoice/items',
            data: formData,
            dataType: 'JSON',
            success: function(result) {
                _hideLoader('BTN_SAVE_INVOICE_ITEMS');
                if (result.success) {
                    $("#modal_add_items_to_invoice").modal("hide");
                    _showResponseMessage('success', result.msg);
                    _loadIvoiceItems();
                } else {
                    _showResponseMessage('error', result.msg);
                }
            },
            error: function(error) {
                _hideLoader('BTN_SAVE_INVOICE_ITEMS');
                _showResponseMessage('error', 'Ooops...');
            },
            complete: function(resultat, statut) {
                _hideLoader('BTN_SAVE_INVOICE_ITEMS');
                _loadIvoiceItems();
            }
        });
        return false;
    }
});
</script>