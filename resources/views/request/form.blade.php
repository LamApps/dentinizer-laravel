{{ csrf_field() }}
<input type="hidden" name="id" value="{{ ($request)?$request->id:0 }}" />

<section class="form-control-repeater">
    <div class="row">
        <!-- Items repeater -->
        <div class="col-12">
            <div class="card shadow-none bg-transparent border-primary">
                <div class="card-body">
                    <h4 class="card-title">1 - {{ __('locale.select_product_to_request') }} : </h4>
                    <div class="product-repeater">
                        <div data-repeater-list="products">
                            <div data-repeater-item>
                                <div class="row d-flex align-items-end">

                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>{{ __('locale.item') }}</label>
                                            <select id="select_products" name="product_id"
                                                class="form-control form-control-sm js-select2" required>
                                                @if($products)
                                                @foreach($products as $p)
                                                <option value="{{$p->id}}">{{$p->name}} ({{number_format($p->price,2)}} {{env('CURRENCY_SYMBOL')}}/Unit)</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="itemquantity">{{ __('locale.quantity') }}</label>
                                            <input type="number" class="form-control form-control-sm qty" id="itemquantity"
                                                name="quantity" aria-describedby="itemquantity" value="1" required />
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="itemrate">Cost</label>
                                            <input type="number" class="form-control form-control-sm" id="itemrate"
                                                name="rate" aria-describedby="itemrate" placeholder="" readonly />
                                        </div>
                                    </div>



                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="itemtotal">Total</label>
                                            <input type="number" class="form-control form-control-sm" id="itemtotal"
                                                name="total" aria-describedby="itemtotal" placeholder="" readonly />
                                        </div>
                                    </div> -->

                                    <div class="col-md-10 col-12">
                                        <div class="form-group">
                                            <label for="itemdesc">{{ __('locale.description') }}</label>
                                            <textarea class="form-control form-control-sm" id="itemdesc"
                                                name="description" aria-describedby="itemdesc"
                                                placeholder="Description"></textarea>
                                        </div>

                                    </div>

                                    <div class="col-md-2 col-12 mb-50">
                                        <div class="form-group">
                                            <button class="btn btn-outline-danger btn-sm text-nowrap px-1"
                                                data-repeater-delete type="button">
                                                {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}
                                                <span>{{ __('locale.delete') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-icon btn-primary btn-sm" type="button" data-repeater-create>
                                    {!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}
                                    <span>{{ __('locale.new') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice repeater -->
    </div>
</section>

<section>
    <div class="card shadow-none bg-transparent border-primary">
        <div class="card-body">
            <h4 class="card-title">2 - {{ __('locale.send_request_by_email') }} : </h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="patients">{{ __('locale.to') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="to"
                            value="{{ ($request)?$request->to:'' }}" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="patients">{{ __('locale.subject') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="subject"
                            value="{{ ($request)?$request->subject:'Request for Medical Supplies' }}" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="cf-default-textarea">{{ __('locale.message') }}</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-sm" rows="5" id="message" name="message"
                                placeholder="Enter message">{{ ($request)?$request->message:'' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('.js-select2').select2();
});
/* function onInputQty(el){
    //alert('ok');
    quantity = $(el).val();
    console.log(quantity);
}
$('#select_products').on('change', function() {
    product_id = this.value;
    if (product_id > 0) {
        $.ajax({
            url: '/admin/get/price/product/' + product_id,
            dataType: 'json',
            success: function(response) {
                quantity = $('#itemquantity').val();
                var rate = response.price;
                console.log(rate);
                $('#itemrate').val(rate);
                var total = quantity * rate;
                $('#itemtotal').val(total);
            },
        }).done(function() {});
    }
}); */
/* $('.qty').on('input', function() {
    quantity = $(this).val();
    console.log(quantity);
    var rate = $('#itemrate').val();
    var total = quantity * rate;
    $('#itemtotal').val(total);
}); */




$('.product-repeater, .repeater-default').repeater({
    show: function() {
        $(this).slideDown();
        // Feather Icons
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
        $('.js-select2').select2();
    },
    hide: function(deleteElement) {
        if (confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
        }
    }
});
</script>