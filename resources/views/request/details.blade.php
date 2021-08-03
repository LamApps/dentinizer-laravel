@php
$cssArray=array('draft'=>'warning','sent'=>'success');
$dtSentDate='';
if($request->sent_at){
$dtSentDate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$request->sent_at);
}
@endphp
<p>
{{ __('locale.status') }} : <span class="badge badge-light-{{$cssArray[$request->status]}}">{{$request->status}}</span>
    @if($dtSentDate)
    at <span class="badge badge-light-success">{{$dtSentDate->format('Y-m-d H:i:s')}}</span>
    @endif
</p>
<p>{{ __('locale.requested_by') }}: <strong>{{$request->user->name}}</strong> {{ __('locale.to') }} <strong>{{$request->to}}</strong></p>
<p>{{ __('locale.subject') }}: <strong>{{$request->subject}}</strong></p>
<p>{{ __('locale.message') }} : </p>
<p>{{$request->message}}</p>

<div class="card shadow-none bg-transparent border-primary">
    <div class="card-body">
    <h4 class="card-title">1 - {{ __('locale.products') }} : </h4>
        <div class="table-responsive">
            <table id="requests_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('locale.item') }}</th>
                        <th>{{ __('locale.description') }}</th>
                        <th>{{ __('locale.quantity') }}</th>
                        <th style="text-align: right;">{{ __('locale.rate') }}</th>
                        <th style="text-align: right;">{{ __('locale.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($items))
                    @foreach($items as $item)
                    <tr>
                        <td>
                            {{$item->product_name}}
                        </td>
                        <td>
                            {{$item->description}}
                        </td>
                        <td>
                            {{$item->quantity}}
                        </td>
                        <td style="text-align: right;">
                            {{number_format($item->rate,2)}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                        <td style="text-align: right;">
                            {{number_format($item->total,2)}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>{{ __('locale.total') }}</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($total,2)}} {{__('locale.'.env('CURRENCY_SYMBOL')) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>