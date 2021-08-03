{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($service)?$service->id:0 }}" />

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="code">{{ __('locale.code') }} <span class="text-danger">*</span></label>
            <input type="text" id="code" value="{{ ($service)?$service->code:'' }}" name="code"
                class="form-control form-control-sm" placeholder="Enter code" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.service_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="service_name" value="{{ ($service)?$service->service_name:'' }}" name="service_name"
                class="form-control form-control-sm" placeholder="Enter Service Name" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.arabic_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="service_name_ar" value="{{ ($service)?$service->service_name_ar:'' }}"
                name="service_name_ar" class="form-control form-control-sm" placeholder="Enter Arabic Name" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="default-05">{{ __('locale.price') }} ({{__('locale.'.env('CURRENCY_SYMBOL')) }}) <span class="text-danger">*</span></label>
            <div class="form-control-wrap">
                <input type="number" min="1" max="9999999999" id="price" value="{{ ($service)?$service->price:1 }}"
                    name="price" class="form-control form-control-sm" required>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <input type="hidden" id="categorie_id_hidden" value="{{ ($service)?$service->category_id:0 }}" />
        <fieldset class="form-group">
            <label>{{ __('locale.category') }} : <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm" id="categoriesSelect" name="category_id" required></select>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="cf-default-textarea">{{ __('locale.note') }}</label>
            <div class="form-control-wrap">
                <textarea class="form-control form-control-sm" cols="30" rows="5" id="a_note" name="note"
                    placeholder="Enter Note">{{ ($service)?$service->note:'' }}</textarea>
            </div>
        </div>
    </div>
</div>