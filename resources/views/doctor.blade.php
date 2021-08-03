@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
<!-- vendor css files -->
<!-- <link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/calendars/fullcalendar.min.css') }}"> -->
<!-- <link rel="stylesheet" href="{{ asset('assets/plugins/calendar/css/fullcalendar.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/calendar/css/custom-calendar.css') }}" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/app-calendar.css') }}"> 
<link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
<style>
.fc-event.fc-draggable,
.fc-event span {
    color: #fff !important;
}
</style>
@endsection

@section('content')

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title">Dashboard</h4> -->
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar" class="fc-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.js"></script>
<script src="/json/fullcalendar/ar.js"></script>

@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>

<script>

var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();
var previewEventPopup = $('#previewEventPopup');


// Calendar plugins
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    @if($lang=='ar')
    locale: 'ar',
    @endif
    events: {!!$events!!},
    editable: true,
    //dragScroll: true,
    dayMaxEvents: 2,
    eventResizableFromStart: true,
    customButtons: {
      sidebarToggle: {
        text: 'Sidebar'
      }
    },
    headerToolbar: {
      start: 'sidebarToggle, prev,next, title',
      end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    //direction: direction,
    initialDate: new Date(),
    navLinks: true, // can click day/week names to navigate views
    eventClassNames: function ({ event: calendarEvent }) {
      //const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
      const colorName = 'info';

      return [
        // Background Color
        'bg-light-' + colorName
      ];
    },
    eventClick: function(info) {
        //console.log(info.event.extendedProps.p_id);
        //console.log(info.event.extendedProps.d_id);
        window.location.href = '/profile/patient/' + info.event.extendedProps.p_id;
    },
	drop: function(date, allDay) { // this function is called when something is dropped

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

  // Render calendar
  calendar.render();
</script>
@endsection


















