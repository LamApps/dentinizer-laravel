{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($payment)?$payment->id:0 }}" />
<input type="hidden" id="INPUT_HIDDEN_INVOICE_ID" name="invoice_id"
    value="{{ ($payment)?$payment->invoice_id:$invoice_id }}" />


<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="payment_method">{{ __('locale.payment_method') }} <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm" id="payment_method" name="payment_method" required>
                <option value="Cash" {{ ($payment)?(($payment->payment_method=='Cash')?'selected':''):'' }}>Cash
                </option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            @php
            $dtNow = Carbon\Carbon::now();
            $payment_date =$dtNow->format('Y-m-d');
            if($payment && $payment->payment_date!=null){
            $dt = Carbon\Carbon::createFromFormat('Y-m-d',$payment->payment_date);
            $payment_date = $dt->format('Y-m-d');
            }
            @endphp

            <label for="fp-payment-date">{{ __('locale.payment_date') }} <span class="text-danger">*</span></label>
            <input type="text" id="fp-payment-date" class="form-control flatpickr-basic form-control-sm"
                name="payment_date" value="{{$payment_date}}" placeholder="YYYY-MM-DD" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="patients">{{ __('locale.amount') }} ({{__('locale.'.env('CURRENCY_SYMBOL')) }})<span class="text-danger">*</span></label>
            <input type="number" min="1" class="form-control form-control-sm" name="amount"
                value="{{ ($payment)?$payment->amount:$amount }}" required />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="cf-default-textarea">{{ __('locale.note') }}</label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="3" id="note" name="note"
                    placeholder="Enter Note">{{ ($payment)?$payment->note:'' }}</textarea>
            </div>
        </div>
    </div>
</div>
<script>
$('#fp-payment-date').flatpickr();
</script>