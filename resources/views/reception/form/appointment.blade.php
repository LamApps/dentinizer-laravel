
    {{ csrf_field() }}
    <input type="hidden" id="TYPE_FORM" value="@if($appointment!=null) 1 @else 0 @endif">
    <input type="hidden" name="id" value="@if($appointment!=null) {{ $appointment->id }} @else 0 @endif">
    <div class="row gy-4">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Patient*</label>
                <div class="form-control-wrap">
                    <select class="form-control form-control-lg js-select2" data-search="on" id="patient_id" name="patient_id" required>
                        @foreach($patients as $patient)
                            @php
                                $selected = ($appointment && $appointment->patient_id ===$patient->id)?'selected':'';
                            @endphp
                        <option value="{{ $patient->id }}">{{ ($patient->ar_name)?$patient->ar_name:$patient->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Doctor *</label>
                <div class="form-control-wrap">
                    <select class="form-control form-control-lg js-select2" data-search="on" id="select_doctor" name="doctor_id" required>
                        @foreach($doctors as $doctor)
                            @php
                                $selected = ($appointment && $appointment->doctor_id ===$doctor->user_id)?'selected':'';
                            @endphp
                        <option value="{{ $doctor->user_id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="default-05">Duration(Minutes*)</label>
                <div class="form-control-wrap">
                    <input type="number" min="1" max="480" id="duration" name="duration" value="@if($appointment!=null){{$appointment->duration}}@endif"
                        class="form-control form-control-lg" required>
                </div>
            </div>
        </div>
    </div> -->

    @php
        $duration ='';
        if($appointment!=null){
            $duration = $appointment->duration;
        }
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="select-doctos">Duration(Minutes*)</label>
                <select class="form-control" id="duration" name="duration" required>
                    <option {{($duration==15)?'selected':''}} value="15">15 mins</option>
                    <option {{($duration==30)?'selected':''}} value="30">30 mins</option>
                    <option {{($duration==45)?'selected':''}} value="45">45 mins</option>
                    <option {{($duration==60)?'selected':''}} value="60">60 mins</option>
                    <option {{($duration==90)?'selected':''}} value="90">90 mins</option>
                    <option {{($duration==120)?'selected':''}} value="120">120 mins</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label class="form-label" for="start_time">Choose date *</label>
            @php
                $start_time ='';
                $slot_time = '';
                if($appointment){
                    $dt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$appointment->start_time);
                    $start_time = $dt->format('Y-m-d');
                    $slot_time = $dt->format('H:i');
                }

                if($appointment==null){
                    $dNow = Carbon\Carbon::now();
                    $start_time = $dNow->format('Y-m-d');
                }

            @endphp
            <input type="hidden" id="INPUT_DEFAULT_SLOT" value="{{$slot_time}}">
            <input class="form-control form-control-lg datepicker" id="start_time" name="start_time" onchange="_loadSlots()" type="text" value="{{$start_time}}" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-1">
                <label class="form-label">Choose time slot :</label>
                <div class="alert alert-info p-1 mb-0" id="DIV_TIME_SLOT" role="alert"></div>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label" for="cf-default-textarea">Comment</label>
                <div class="form-control-wrap">
                    <textarea class="form-control form-control-sm" cols="30" rows="5" id="comments" name="comments"
                        placeholder="Write your comment">@if($appointment!=null){{$appointment->comments}}@endif</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="form-control-wrap">
                    <select class="form-control" id="status" name="status" data-placeholder="Select Multiple services" required>
                        <option {{($appointment && $appointment->status ===1)?'selected':''}} value="1">Booked</option>
                        <option {{($appointment && $appointment->status ===2)?'selected':''}} value="2">Confirmed</option>
                        <option {{($appointment && $appointment->status ===3)?'selected':''}} value="3">Canceled</option>
                        <option {{($appointment && $appointment->status ===4)?'selected':''}} value="4">Attended</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <input class="d-none" type="submit" value="SUBMIT" id="SUBMIT_APPOINTMENT_FORM">
<script>
_getNearstAvalabilityTime();
function _getNearstAvalabilityTime(){
    var TYPE_FORM=$("#TYPE_FORM").val();
    if(TYPE_FORM==0){
        var loaderHtml ='<i class="fa fa-spinner spin"></i>';
        $("#DIV_TIME_SLOT").html(loaderHtml);
        var doctor_id = $("#select_doctor").val();
        var start_date = $("#start_time").val();
        if(doctor_id>0 && start_date!=''){
            $.ajax({
                type: "GET",
                url: "/reception/get/nearst/time/" + doctor_id+'/'+start_date,
                dataType: "JSON",
                success: function(result) {
                    $("#start_time").val(result.start_date);
                    _loadSlots();
                },
                error: function(err) {
                    //$("#DIV_TIME_SLOT").html('<i class="fa fa-times></i> Oops! Something went wrong. Please try again later.');
                },
            }).done(function(data) {});
        }
    }
}
var TYPE_FORM=$("#TYPE_FORM").val();
if(TYPE_FORM!=0){
    _loadSlots();
}
function _loadSlots() {
    //alert('_loadSlots');
    var loaderHtml ='<i class="fa fa-spinner spin"></i>';
    $("#DIV_TIME_SLOT").html(loaderHtml);
    var doctor_id = $("#select_doctor").val();
    var start_date = $("#start_time").val();
    //console.log(doctor_id+start_date);
    if(doctor_id>0 && start_date!=''){
        $.ajax({
            type: "GET",
            url: "/reception/get/time/slots/" + doctor_id+'/'+start_date,
            dataType: "html",
            success: function(html) {
                $("#DIV_TIME_SLOT").html(html);
            },
            error: function(err) {
                $("#DIV_TIME_SLOT").html('<i class="fa fa-times></i> Oops! Something went wrong. Please try again later.');
            },
        }).done(function(data) {});
    }   
}
$('#select_doctor').on('change', function() {
    if(TYPE_FORM==0){
        _getNearstAvalabilityTime();
    }else{
        _loadSlots();
    }
});

$(document).ready(function(){
    $('.js-select2').select2();
    var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        hiddenName: false,
        disable: [{from: [0, 0, 0], to: yesterday}],
    });
}); 
</script>
