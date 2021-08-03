{{ csrf_field() }}
<input type="hidden" name="day" value="{{ $day }}">
<input type="hidden" name="doctor_id" value="{{ $doctor_id}}">

<div class="row">
    <div class="col-md-6 form-group">
        <label for="fp-time">Start time</label>
        <input type="text" id="started_at" name="started_at" class="form-control flatpickr-time text-left"
            placeholder="HH:MM" required/>
    </div>
    <div class="col-md-6 form-group">
        <label for="fp-time">End time</label>
        <input type="text" id="ended_at" name="ended_at" class="form-control flatpickr-time text-left"
            placeholder="HH:MM" required/>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="select-doctos">Timing Slot Duration</label>
            <select class="form-control" id="select_slot_duration" name="slot_duration">
                <option value="15">15 mins</option>
                <option value="30">30 mins</option>
                <option value="40">40 mins</option>
                <option value="45">45 mins</option>
                <option value="60">1 Hour</option>
            </select>
        </div>
    </div>
</div>

<script>
$( document ).ready(function() {
    $('.flatpickr-time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
});
</script>