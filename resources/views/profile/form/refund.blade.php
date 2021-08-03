{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($refund)?$refund->id:0 }}" />
<input type="hidden" id="INPUT_HIDDEN_INVOICE_ID" name="invoice_id"
    value="{{ ($refund)?$refund->invoice_id:$invoice_id }}" />

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="refund_code">{{ __('locale.refund_code') }}</label>
            <input type="text" class="form-control form-control-sm" id="refund_code" value="{{ ($refund)?$refund->refund_code:'' }}" readonly/>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            @php
            $dtNow = Carbon\Carbon::now();
            $refund_date =$dtNow->format('Y-m-d');
            if($refund && $refund->refund_date!=null){
            $dt = Carbon\Carbon::createFromFormat('Y-m-d',$refund->refund_date);
            $refund_date = $dt->format('Y-m-d');
            }
            @endphp

            <label for="fp-refund-date">{{ __('locale.refund_date') }} <span class="text-danger">*</span></label>
            <input type="text" id="fp-refund-date" class="form-control flatpickr-basic form-control-sm"
                name="refund_date" value="{{$refund_date}}" placeholder="YYYY-MM-DD" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="patients">{{ __('locale.amount') }} ({{__('locale.'.env('CURRENCY_SYMBOL')) }})<span class="text-danger">*</span></label>
            <input type="number" min="1" class="form-control form-control-sm" name="amount"
                value="{{ ($refund)?$refund->amount:$amount }}" required />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="reason">{{ __('locale.reason') }} <span class="text-danger">*</span></label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="3" id="reason" name="reason"
                    placeholder="Enter Note" required>{{ ($refund)?$refund->reason:'' }}</textarea>
            </div>
        </div>
    </div>
</div>
<script>
$('#fp-refund-date').flatpickr();
</script>