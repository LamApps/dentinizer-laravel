<p>
<button type="button" data-toggle="tooltip" data-placement="top" title="Add slot" onclick="_formSchedule({{ $doctor_id }},'{{ $day }}')" class="btn btn-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button>
</p>
@if(isset($schedules) && count($schedules)>0)
@foreach($schedules as $schedule)
@php
$dt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$schedule->slot);
$slot = $dt->format('H:i');
@endphp
<button type="button" onclick="_deleteSlot({{ $schedule->id }})" class="btn btn-outline-primary mb-1">{{ $slot }}
    {!!\App\Library\Helpers\Helper::getSvgIconeByAction('DELETE')!!}</button>
@endforeach
@else
<div class="alert alert-warning" role="alert">
    <div class="alert-body">Not Available</div>
</div>
@endif