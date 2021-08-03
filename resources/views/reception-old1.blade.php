@extends('layouts.app')
@section('content')
<style></style>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>

<div class="content-wrapper col-md-12">    
	<div class="row gutters">
        <div class="card"> 
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">              
                <div class="card-body">
				    <div class="row">
						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">
							<div class="row">
								<ul>
									@foreach(json_decode($events) as $event)
										<li style="    margin-bottom: 5%;">
											<div class="checkbox">
												<label><span class="{{$event->className}}"> {{$event->title}}</span></label>
												<input type="checkbox"  name="doctor_id[]"  onchange="getDoctorappointmentCalender()"
												class="currentcheckdoctor" value="{{$event->d_id}}"> 
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>

						<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
							<div class="row">
								<div id="calendar" class="fc-calendar"></div>
							</div>
						</div>
					</div>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var date = new Date();
	var d    = date.getDate();
	var m    = date.getMonth();
	var y    = date.getFullYear();
	var previewEventPopup = $('#previewEventPopup');
	
	$('#calendar').fullCalendar({
		header: {
			left: 'prev, next',
			center: 'title',
			right: 'today, month, agendaWeek, agendaDay'
		},
		eventClick: function(info) {
			window.location.href = 'patientprofile/'+ info.p_id +"/" + info.d_id;
        },
		
		events: {!! $events !!},
		
		editable  : true,
		eventLimit: false,
		droppable : true, // this allows things to be dropped onto the calendar
		drop: function (date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');

			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;

			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
		}
	});

</script>

<script type="text/javascript">
	function getDoctorappointmentCalender() {
		var doctor_id = [];
		$('input[name="doctor_id[]"]:checked').each(function() {
			doctor_id.push(this.value); 
		});

		$.ajax({
			type: "post",
			url : '{{ route("reception.getDoctorappointmentCalender") }}',
			data: {
				"_token": "{{ csrf_token() }}",
				"doctor_id": doctor_id
			},
			success: function(data){
				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource',data);
			},
		});
	}
</script>
@endsection
