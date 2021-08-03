@php
$percent = '';
if($discount_amount_type=='percentage'){
$percent = '('.$discount_amount.'%)';
}
@endphp

<!-- DISCOUNT FORM -->
<div class="row">
    <div class="col-md-12" id="BLOCK_DISCOUNT"></div>
</div>
<!-- DISCOUNT FORM -->

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('locale.teeth_id') }}</th>
                <th>{{ __('locale.service') }}</th>
                <th>{{ __('locale.quantity') }}</th>
                <th>{{ __('locale.rate') }}</th>
                <th>{{ __('locale.price') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="TBODY_TABLE_ITEMS">
            @if(count($items)>0)
            @foreach($items as $item)
            <tr class="">
                <td>
                    {{$item->teeth_id}}
                </td>
                <td class="pl-0 pt-7">
                    <p><strong>{{$item->service->service_name}}</strong></p>
                    <p class="mb-0">{{$item->note}}</p>
                </td>
                <td class="text-right pt-7">{{$item->quantity}}</td>
                <td class="text-right pt-7">{{number_format($item->rate,2)}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <td class="text-success pr-0 pt-7 text-right">{{number_format($item->total,2)}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <th>
                    <button type="button" class="btn btn-sm btn-clean btn-icon"
                        onclick="_formEstimateItem({{$item->id}},{{$item->estimate_id}})" title="Edition"><i
                            class="flaticon-edit"></i></button>
                </th>
            </tr>
            @endforeach
            <!-- BEGIN:ESTIMATE FOOTER -->
            <tr class="font-weight-boldest">
                <td colspan="4" class="text-right pt-7">{{ __('locale.subtotal') }}</td>
                <td class="text-success pr-0 pt-7 text-right">{{$calcul['subtotal']}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <td></td>
            </tr>


            <tr class="font-weight-boldest">
                <td colspan="4" class="text-right pt-7">{{ __('locale.discount') }} {{$percent}}</td>
                <td class="text-danger pr-0 pt-7 text-right">{{$calcul['discount_amount']}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <td>
                    <button type="button" class="btn btn-icon btn-sm btn-outline-primary"
                        onclick="_formDiscount({{$item->invoice_id}})" data-toggle="tooltip"
                        title="Edit discount">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}</button>
                </td>
            </tr>


            @if($tax_percentage>0)
            <tr class="font-weight-boldest">
                <td colspan="4" class="text-right pt-7">{{ __('locale.tax') }} ({{$tax_percentage}}%)</td>
                <td class="text-danger pr-0 pt-7 text-right">{{$calcul['tax_amount']}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <td></td>
            </tr>
            @endif

            <tr class="font-weight-boldest">
                <td colspan="4" class="text-right pt-7">{{ __('locale.total') }}</td>
                <td class="text-success pr-0 pt-7 text-right">{{$calcul['total']}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                <td></td>
            </tr>
            <!-- END:ESTIMATE FOOTER -->
            @else
            <tr>
                <td colspan="5" class="text-center">No items</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>