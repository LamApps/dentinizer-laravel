<div class="row">
    <div class="col-md-12">
        <h5>{{ __('locale.record_audio') }} : </h5>
        <!-- recoder -->
        <div class="mb-2" id="controls">
            <button id="recordButton" type="button" data-toggle="tooltip" data-placement="top" title="Recorde"
                class="btn btn-icon btn-danger">
                {!!\App\Library\Helpers\Helper::getSvgIconeByAction('MIC')!!}
            </button>
            <button id="pauseButton" type="button" data-toggle="tooltip" data-placement="top" title="Pause"
                class="btn btn-icon btn-outline-primary" disabled>
                {!!\App\Library\Helpers\Helper::getSvgIconeByAction('PAUSE')!!}
            </button>
            <button id="stopButton" type="button" data-toggle="tooltip" data-placement="top" title="Stop"
                class="btn btn-icon btn-outline-primary" disabled>
                {!!\App\Library\Helpers\Helper::getSvgIconeByAction('STOP')!!}
            </button>
        </div>
        
        <!-- timer -->
        <p id="timer-block" class="d-none"><span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span></p>
        <!-- timer -->

        <p id="formats" class="d-none"><small>Format: start recording to see sample rate</small></p>
        <input type="hidden" id="BLOB_FILE" value="">
        <ul class="list-unstyled" id="recordingsList"></ul>
        <!-- recoder -->
    </div>
</div>
<script src="{{ asset('new-assets/js/recorder.js') }}"></script>
<script src="{{ asset('new-assets/js/timer.js') }}"></script>
<script src="{{ asset('new-assets/js/recorder-form.js') }}"></script>
