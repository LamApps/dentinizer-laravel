{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($category)?$category->id:0 }}" />

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="activeCheckbox1" value="1" name="is_active"
                    {{ ($category!=null && $category->is_active==1)?'checked' : '' }} />
                <label class="form-check-label" for="activeCheckbox1">{{ __('locale.activate') }}</label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.service_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="name" value="{{ ($category)?$category->name:'' }}" name="name"
                class="form-control form-control-sm" placeholder="Enter Category Name" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="first-name">{{ __('locale.arabic_name') }} <span class="text-danger">*</span></label>
            <input type="text" id="name_ar" value="{{ ($category)?$category->name_ar:'' }}" name="name_ar"
                class="form-control form-control-sm" placeholder="Enter Arabic Name" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label class="form-label" for="order_show">{{ __('locale.order_show') }} </label>
            <input type="number" id="order_show" value="{{ ($category)?$category->order_show:1 }}" name="order_show"
                class="form-control form-control-sm" placeholder="Enter Order show" required>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="iconFile">{{ __('locale.icon') }} : </label>
            <input type="file" name="file" class="form-control-file" id="iconFile" />
        </div>
    </div>
    <div class="col-lg-2">
        @if($category && $category->path_icon)
        <img src="{{asset(base64_decode($category->path_icon))}}" class="img-fluid" />
        @endif
    </div>
</div>