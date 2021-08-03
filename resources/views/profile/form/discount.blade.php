<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
        <form id="formDiscount">
            <input type="hidden" name="id" value="{{ ($row)?$row->id:0 }}">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ __('locale.type') }}</label>
                        <select id="discount_type" name="discount_type" class="form-control form-control-sm" required>
                            @php
                            $selectedBeforeTax = ($row && $row->discount_type ==='before_tax')?'selected':'';
                            $selectedAfterTax = ($row && $row->discount_type ==='after_tax')?'selected':'';
                            @endphp
                            <option {{$selectedBeforeTax}} value="before_tax">Before tax</option>
                            <!-- <option {{$selectedAfterTax}} value="after_tax">After tax</option> -->
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="discount_amount">{{ __('locale.discount') }} : <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm" type="number" name="discount_amount"
                            value="{{ ($row)?$row->discount_amount:0 }}" id="discount_amount" required />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>{{ __('locale.mode') }}</label>
                        <select id="taxeOneSelect" name="discount_amount_type" class="form-control form-control-sm"
                            required>
                            @php
                            $selectedPercent = ($row && $row->discount_amount_type ==='percentage')?'selected':'';
                            $selectedFixed = ($row && $row->discount_amount_type ==='fixed_amount')?'selected':'';
                            @endphp
                            <option {{$selectedPercent}} value="percentage">Pourcentage (%)</option>
                            <option {{$selectedFixed}} value="fixed_amount">Montant fixe</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" onclick="annulateDiscount();" class="btn btn-sm btn-outline-danger">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('CANCEL')!!} {{ __('locale.cancel') }}</button>
                    <button type="button" onclick="$('#formDiscount').submit();"
                        class="btn btn-sm btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('SAVE')!!} {{ __('locale.save') }}<span
                            id="BTN_SAVE_DISCOUNT"></span></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$("#formDiscount").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        _showLoader('BTN_SAVE_DISCOUNT');
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: 'POST',
            url: '/profile/form/discount',
            data: formData,
            dataType: 'JSON',
            success: function(result) {
                _hideLoader('BTN_SAVE_DISCOUNT');
                if (result.success) {
                    _showResponseMessage('success', result.msg);
                    $('#BLOCK_DISCOUNT').html('');
                } else {
                    _showResponseMessage('error', result.msg);
                }
            },
            error: function(error) {
                _hideLoader('BTN_SAVE_DISCOUNT');
                _showResponseMessage('error', 'Veuillez vérifier les champs du formulaire...');
            },
            complete: function(resultat, statut) {
                $('#BLOCK_DISCOUNT').html('');
                _hideLoader('BTN_SAVE_DISCOUNT');
                _loadIvoiceItems();
            }
        });
        return false;
    }
});
</script>