@extends('layouts.app')

@section('content')

<script>

    function delete_func(val) {
        document.getElementById(val).submit();
    }

</script>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Patient Lists</li>
    </ol>
</div>
<div class="content-wrapper">    
    <div class="row">    
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
            <h5 class='text-success'>You have total {{ count(json_decode($patients)) }} Patients.</h5>
        </div>    
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Duration(Mins)</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Birthday</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(json_decode($patients) as $patient)
                                <tr onClick = "window.location.href = 'plan/patient/{{$patient->p_id}}'" style="cursor: url(hand.cur), pointer">
                                    <td><span>{{ $patient->start }}</span></td>
                                    <td><span>{{ $patient->end }}</span></td>
                                    <td><span>{{ $patient->p_name }}</span></td>
                                    <td><span>{{ $patient->p_email }}</span></td>
                                    <td><span>{{ $patient->p_birthday }}</span></td>
                                    <td><span>{{ $patient->p_address }}</span></td>
                                    <td><span>{{ $patient->p_phone }}</span></td>
                                    <td>
                                        @if($patient->p_state == 0)
                                            <span class="tb-status text-success">Open</span>
                                        @elseif($patient->p_state == 1)
                                            <span class="tb-status text-warning">Complete</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function(){
   
});
</script>

@endsection
