@extends('layouts/layoutMaster')

@section('title', 'Appointments Lists')

@section('vendor-style')

@endsection

@section('page-style')
{{-- Page Css files --}}
<style>
audio {
    width:100%;
}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recorder</h4>
                <!-- recoder -->
                <div id="controls">
                    <button id="recordButton" type="button" data-toggle="tooltip" data-placement="top" title="Recorde" class="btn btn-icon btn-outline-primary">
                        <i data-feather="mic"></i>
                    </button>
                    <button id="pauseButton" type="button" data-toggle="tooltip" data-placement="top" title="Pause" class="btn btn-icon btn-outline-primary" disabled>
                        <i data-feather="pause-circle"></i>
                    </button>
                    <button id="stopButton" type="button" data-toggle="tooltip" data-placement="top" title="Stop" class="btn btn-icon btn-outline-primary" disabled>
                        <i data-feather="stop-circle"></i>
                    </button>
                </div>
                <div id="formats">Format: start recording to see sample rate</div>
                <p><strong>Recordings:</strong></p>
                <ol id="recordingsList"></ol>
                <!-- recoder -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/js/recorder.js') }}"></script>
<!-- <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script> -->
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/recorder-script.js') }}"></script>
<script src="{{ asset('new-assets/js/main.js') }}"></script>
@endsection