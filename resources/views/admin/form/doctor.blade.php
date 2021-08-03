{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($doctor)?$doctor->id:0 }}" />
<input type="hidden" name="user_id" value="{{ ($doctor)?$doctor->user_id:0 }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.name') }}</label>
            <input type="text" value="{{ ($doctor)?$doctor->user->name:'' }}" name="name"
                class="form-control form-control-sm" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.username') }}</label>
            <input type="text" value="{{ ($doctor)?$doctor->user->username:'' }}" name="username"
                class="form-control form-control-sm" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="birth-day">{{ __('locale.birthday') }}</label>
            <input type="text" id="doctor_birthday" name="birthday" data-date-format="yyyy-mm-dd"
                value="{{ ($doctor)?$doctor->birthday:'' }}" class="form-control form-control-sm datepicker">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="birth-day">{{ __('locale.account_state') }}</label>
            <select class="form-control form-control-sm" name="state">
                <option value="0" {{ ($doctor)?(($doctor->user->state==0)?'selected':''):'' }}>Pending</option>
                <option value="1" {{ ($doctor)?(($doctor->user->state==1)?'selected':''):'' }}>Verified</option>
                <option value="2" {{ ($doctor)?(($doctor->user->state==2)?'selected':''):'' }}>Suspend</option>
            </select>
        </div>
    </div>

</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.phone') }}</label>
            <input type="text" value="{{ ($doctor)?$doctor->phone:'' }}" name="phone"
                class="form-control form-control-sm">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="default-05">{{ __('locale.target') }} ({{__('locale.'.env('CURRENCY_SYMBOL')) }})</label>
            <div class="form-control-wrap">
                <input type="number" min="1" max="9999999999" name="target" value="{{ ($doctor)?$doctor->target:'' }}"
                    class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="cf-default-textarea">{{ __('locale.address') }}</label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="5"
                    name="address">{{ ($doctor)?$doctor->address:'' }}</textarea>
            </div>
        </div>
    </div>
</div>

<script>
$('#doctor_birthday').pickadate({
    format: 'yyyy-mm-dd',
    hiddenName: false
})
</script>