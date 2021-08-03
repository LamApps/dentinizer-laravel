{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($item)?$item->id:0 }}" />
<input type="hidden" name="patient_id" value="{{ ($item)?$item->patient_id:$patient_id }}" />
<input type="hidden" name="teeth_id" value="{{ ($item)?$item->teeth_id:$teeth_id }}" />
<!-- <input type="hidden" name="doctor_id" value="{{ ($item)?$item->doctor_id:$doctor_id }}" /> -->

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="select-services">Service</label>
            <select class="form-control form-control-sm js-select2" id="select_services" name="service_id">
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="select-services">Doctor</label>
            <select class="form-control form-control-sm js-select2" id="select_doctors" name="doctor_id">
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
            <input type="number" min="1" id="quantity" value="{{ ($item)?$item->quantity:1 }}" name="quantity"
                class="form-control form-control-sm" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="rate">Rate <span class="text-danger">*</span></label>
            <input type="number" id="rate" value="{{ ($item)?$item->rate:'' }}" name="rate"
                class="form-control form-control-sm" required readonly>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="total">total <span class="text-danger">*</span></label>
            <input type="number" id="total" value="{{ ($item)?$item->total:'' }}" name="total" class="form-control form-control-sm" required readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="cf-default-textarea">Note</label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="5" id="note" name="note" placeholder="Enter Note">{{ ($item)?$item->note:'' }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="select_types">Type</label>
            <select class="form-control form-control-sm" id="select_types" name="type">
                <!-- <option value="existing" {{ ($item)?(($item->type=='existing')?'selected':''):'' }}>Existing</option> -->
                <option value="planned" {{ ($item)?(($item->type=='planned')?'selected':''):'' }}>Planned</option>
                <option value="completed" {{ ($item)?(($item->type=='completed')?'selected':''):'' }}>Completed</option>
            </select>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.js-select2').select2();
});
$('#select_services').on('change', function() {
  calculateTotalPriceService(this.value);
});
$('#quantity').on('input', function() {
    onChangeQuantity();
});
</script>