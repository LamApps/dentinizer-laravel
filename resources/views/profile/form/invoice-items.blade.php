<input type="hidden" name="invoice_id" value="{{ $invoice_id }}">
<div class="table-responsive">
    <table id="services_to_invoice_datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <label class="checkbox checkbox-single">
                        <input type="checkbox" value="" class="group-checkable" />
                        <span></span>
                    </label>
                </th>
                <th>{{ __('locale.teeth') }}</th>
                <th>{{ __('locale.service') }}</th>
                <th>{{ __('locale.note') }}</th>
                <th>{{ __('locale.quantity') }}</th>
                <th>{{ __('locale.rate') }}</th>
                <th>{{ __('locale.total') }}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp
<script>
var invoice_id = $('#INPUT_HIDDEN_INVOICE_ID').val();
var dtStiUrl = '/profile/sdt/services/to/invoice/' + invoice_id;
var sti_datatable = $('#services_to_invoice_datatable');
sti_datatable.DataTable({
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
        url: dtStiUrl,
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

sti_datatable.on('change', '.group-checkable', function() {
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

sti_datatable.on('change', 'tbody tr .checkbox', function() {
    $(this).parents('tr').toggleClass('active');
});
</script>