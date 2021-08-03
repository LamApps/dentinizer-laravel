{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($patient)?$patient->id:0 }}" />

<div class="row gy-4">
    <div class="col-md-4">
        <div class="form-group">
            <label for="select-services">{{ __('locale.gender') }}</label>
            <select class="form-control form-control-sm" name="state">
                <option {{ ($patient)?(($patient->gender=='Mr')?'selected':''):'' }} value="Mr">Mr</option>
                <option {{ ($patient)?(($patient->gender=='Mrs')?'selected':''):'' }} value="Mrs">Mrs</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.name') }}*</label>
            <input type="text" id="e_name" name="name" class="form-control form-control-sm"
                value="{{ ($patient)?$patient->name:'' }}" placeholder="Enter Full name" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.arabic_name') }}</label>
            <input type="text" id="e_ar_name" name="ar_name" class="form-control form-control-sm"
                placeholder="Enter Full name" value="{{ ($patient)?$patient->ar_name:'' }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="display-name">{{ __('locale.nationality') }}</label>
            <input type="text" name="nationality" class="form-control form-control-sm"
                value="{{ ($patient)?$patient->nationality:'' }}" placeholder="Enter nationality" >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="display-name">{{ __('locale.iqama') }}</label>
            <input type="text" name="iqama_id" class="form-control form-control-sm"
                value="{{ ($patient)?$patient->iqama_id:'' }}" placeholder="" >
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="birth-day">{{ __('locale.birthday') }}</label>
            <input type="text" id="e_birthday" name="birthday" class="form-control form-control-sm"
                value="{{ ($patient)?$patient->birthday:'' }}" placeholder="Enter your birthday">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="phone-no">{{ __('locale.phone') }}</label>
            <input type="text" id="e_phone" name="phone" class="form-control form-control-sm"
                value="{{ ($patient)?$patient->phone:'' }}" placeholder="Phone Number">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="address">{{ __('locale.address') }}</label>
            <textarea class="form-control form-control-sm" cols="30" rows="5" name="address"
                placeholder="Address">{{ ($patient)?$patient->address:'' }}</textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="medicalConditonsMultiSelect">{{ __('locale.medical_conditions') }}</label>
            <select class="form-control" id="medicalConditonsMultiSelect" name="medical_conditions[]" multiple="multiple">
                @foreach($medicalconditionsList as $m)
                @php
                $codes_array=[];
                if($patient)
                    $codes_array = explode(';', $patient->medical_conditions);
                @endphp
                <option value="{{ $m->code }}" {{ (in_array($m->code,$codes_array))?'selected':'' }} >{{ $m->en_name }} {{ $m->ar_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="select-services">{{ __('locale.status') }}</label>
            <select class="form-control form-control-sm" name="state">
                <option {{ ($patient)?(($patient->state==0)?'selected':''):'' }} value="0">Done</option>
                <option {{ ($patient)?(($patient->state==1)?'selected':''):'' }} value="1">Complete</option>
            </select>
        </div>
    </div>

</div>
<script>
$('#e_birthday').pickadate({
    format: 'yyyy-mm-dd',
    hiddenName: false
})
</script>