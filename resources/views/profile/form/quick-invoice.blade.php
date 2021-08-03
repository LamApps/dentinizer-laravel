{{ csrf_field() }}

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<input type="hidden" id="INPUT_HIDDEN_INVOICE_ID" name="id" value="0" />
<input type="hidden" name="patient_id" value="{{ $patient_id }}" />

<!-- begin::header -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="select_doctors">{{ __('locale.doctor') }}</label>
            @php
            $readonly='';
            if(Auth::user()->user_type == "doctor"){
            $readonly='readonly';
            }
            @endphp
            <select class="form-control form-control-sm js-select2" id="select_doctors_quick_invoice" name="doctor_id"
                {{ $readonly }}>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="select_teeth">{{ __('locale.teeth') }}</label>
            <select name="teeth_id" class="form-control form-control-sm js-select2" id="select_teeth">
                @if($teeths)
                @foreach($teeths as $t)
                <option value="{{$t->number}}">{{$t->number}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<!-- end::header -->
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="services_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <label class="checkbox checkbox-single">
                                <input type="checkbox" value="" class="group-checkable" />
                                <span></span>
                            </label>
                        </th>
                        <th>{{ __('locale.code') }}</th>
                        <th>{{ __('locale.service') }}</th>
                        <th>{{ __('locale.price') }}</th>
                        <th>{{ __('locale.category') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
var dtServicesUrl = '/admin/sdt/list/services';
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
        url: dtServicesUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 5,
});

services_datatable.on('change', '.group-checkable', function() {
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

services_datatable.on('change', 'tbody tr .checkbox', function() {
    $(this).parents('tr').toggleClass('active');
});
</script>