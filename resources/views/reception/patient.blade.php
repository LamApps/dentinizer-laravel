@extends('layouts/layoutMaster')

@section('title', 'Patient Lists')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.date.css') }}" />
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Patient Lists</h4>
                <h5 class='text-success'>You have total {{ count($patients) }} Patients.</h5>

                <div class="row mb-2">    
                    <div class="col-md-8">
                        
                    </div>

                    <!-- <div class="col-md-5 text-right">
                        <a href="#" id="new_modal_btn" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#add_invoice_modal"><span><i data-feather="plus"></i> Create Quick Invoice</span></a>
                    </div> -->  

                    <div class="col-md-4 text-right">
                        <a href="#" id="new_service_btn" class="btn btn-icon btn-outline-primary" data-toggle="modal" data-target="#add_patient_modal"><i data-feather="plus"></i></a>
                    </div> 
                </div>


                <div class="table-responsive">
                        <table class="datatable table table-bordered"> 
                        <thead>
                                <tr>
                                    <th>En name</th>
                                    <th>Ar name</th>
                                    <th>Birthday</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th class="tb-tnx-action">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($patients as $patient)
                                <tr>
                                        <td style="cursor: pointer"><span onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" >{{ $patient->name }}</span></td>
                                        <td onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" style="cursor: pointer"><span>{{ $patient->ar_name }}</span></td>
                                        <td onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" style="cursor: pointer"><span>{{ $patient->birthday }}</span></td>
                                        <td onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" style="cursor: pointer"><span>{{ $patient->address }}</span></td>
                                        <td onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" style="cursor: pointer"><span>{{ $patient->phone }}</span></td>
                                        <td onClick = "window.location.href = '/profile/patient/{{$patient->id}}'" style="cursor: pointer">
                                            @if($patient->state == 0)
                                                <span class="tb-status text-success">Open</span>
                                            @elseif($patient->state == 1)
                                                <span class="tb-status text-warning">Complete</span>
                                            @endif
                                        </td>
                                    

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button"  data-toggle="modal" data-target="#edit_patient_modal"  data-id="{{ $patient }}" class="btn btn-outline-info">
                                            {!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!}
                                            </button>
                                            <button onclick="delete_func('delete_frm_{{ $patient->id }}')" type="button" class="btn btn-outline-danger">
                                                <form action="{{ route('reception.patient.destroy', $patient->id)}}" name="delete_frm_{{ $patient->id }}" id="delete_frm_{{ $patient->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i data-feather="trash"></i>
                                                </form>    
                                            
                                            </button>
                                            <a href="/profile/patient/{{$patient->id}}" class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('VIEW')!!}</a>                                            
                                        </div>                                    
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



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_patient_modal">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div  class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Add Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row gy-4">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">English name*</label>
                            <input type="text" id="a_name" name="a_name" class="form-control form-control-lg" placeholder="Enter Full name" require>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">Arabic name*</label>
                            <input type="text" id="ar_name" name="ar_name" class="form-control form-control-lg" placeholder="Enter Full name" require>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="display-name">Email*</label>
                            <input type="text" id="a_email" name="a_email" class="form-control form-control-lg"  placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="birth-day">Date of Birth</label>
                            <input type="text" id="a_birthday" name="a_birthday" class="form-control form-control-lg" placeholder="Enter your birthday">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phone-no">Phone Number</label>
                            <input type="text" id="a_phone" name="a_phone" class="form-control form-control-lg" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="a_address" name="a_address" class="form-control form-control-lg" placeholder="Enter address">
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button  class="btn btn-primary" id="patient_save_btn"><i data-feather="save"></i>&nbsp;Save</button>                                        
                <button  data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>                                            
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="edit_patient_modal">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div  class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="e_patient_id" name="e_patient_id">
                <div class="row gy-4">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">English name*</label>
                            <input type="text" id="e_name" name="e_name" class="form-control form-control-lg" placeholder="Enter Full name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="first-name">Arabic name*</label>
                            <input type="text" id="e_ar_name" name="e_ar_name" class="form-control form-control-lg" placeholder="Enter Full name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="display-name">Email*</label>
                            <input type="text" id="e_email" name="e_email" class="form-control form-control-lg"  placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="birth-day">Date of Birth</label>
                            <input type="text" id="e_birthday" name="e_birthday" class="form-control form-control-lg" placeholder="Enter your birthday">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phone-no">Phone Number</label>
                            <input type="text" id="e_phone" name="e_phone" class="form-control form-control-lg" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" id="e_address" name="e_address" class="form-control form-control-lg" placeholder="Enter address">
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button  class="btn btn-primary" id="patient_update_btn"><i data-feather="save"></i>&nbsp;Update</button>                                        
                <button  data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>                                            
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_invoice_modal">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div  class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Add Quick Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="title text-right" id="code"></h5>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">From</label>
                            <div class="form-control-wrap">
                                <select id="from" name="from" class="form-control" required>
                                    @foreach($doctors as $doctor)
                                        <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">To</label>
                            <div class="form-control-wrap">
                                <select id="to" name="to" class="form-control" required>
                                    @foreach($patients as $patient)
                                        <option value="{{$patient->id}}">{{$patient->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <table class="table" style="border:1px solid #eee" id = "bill_tbl" name = "bill_tbl">
                            <thead class="table" >
                                <tr>
                                    <th><span class="overline-title">Service</span></th>
                                    <th><span class="overline-title">Amount</span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="plan_tbody">
                                @foreach($services as $service)
                                    <tr>
                                        <td><span class="overline-title">{{$service->service_name}}</span></td>
                                        <td><span class="overline-title">{{$service->price}}</span></td>
                                        <td class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" max="{{$service->price}}"  value = "{{$service->id}}" id="uid{{ $service->id }}">
                                                <label class="custom-control-label" for="uid{{ $service->id }}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="0" max="9999999999" id="total" name="total" value = "0" class="form-control form-control-lg" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Totoal</span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button  class="btn btn-primary" id="invoice_save_btn"><i data-feather="save"></i>&nbsp;Save</button>                                        
                <button  data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>                                            
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>


@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>

    $('#a_birthday').pickadate({
        format: 'yyyy-mm-dd',
        hiddenName: false
    })
    $('#e_birthday').pickadate({
        format: 'yyyy-mm-dd',
        hiddenName: false
    })

    var save_arr = Array();
    var time     = new Date().getTime(); 
    var total    = 0; 

    $('#plan_tbody [type="checkbox"]').click(function(e) {
        total    = 0; 
        save_arr = [];
        $('#plan_tbody [type="checkbox"]').each(function(i, chk) {
            if(chk.checked){
                save_arr.push(chk.value);
                total += parseInt(chk.max);
                $("#total").val(total);
            }
        });      
    });

    $("#invoice_save_btn").on('click', function(e) {
        $.ajax({
            url: '{{route("reception.invoice.store")}}',
            type:"POST",
            data:{
                code    : time,
                from    : $("#from").val(),
                to      : $("#to").val(),
                total   : $('#total').val(),
                invoices: save_arr,
                _token: "{{ csrf_token() }}",
            },
            success:function(response){
                $("#add_invoice_modal").modal("hide");
                location.reload();
            },
        });
    });
</script>

<script>
$(document).ready(function(){
    var table = $('.datatable').DataTable({
        responsive:true
    });
    
    $("#patient_save_btn").click(function(e){
        e.preventDefault();
        var name = $("#a_name").val();
        var ar_name = $("#ar_name").val();
        var email = $("#a_email").val();
        var birthday = $("#a_birthday").val();
        var phone = $("#a_phone").val();
        var address = $("#a_address").val();
        if(name != "" && email != "" ) {
            $.ajax({
                url: '{{route("reception.patient.store")}}',
                type:"POST",
                data:{
                    name: name,
                    ar_name: ar_name,
                    email: email,
                    birthday: birthday,
                    phone: phone,
                    address: address,
                    _token: "{{ csrf_token() }}",
                },
                success:function(response){
                    $("#add_patient_modal").modal('hide');
                   
                    window.location.href = '{{route("reception.patient")}}';
                },
            });
        }
    });


    
    $('#edit_patient_modal').on('show.bs.modal', function(e) {
        var patient_data = $(e.relatedTarget).data('id');
        $("#e_patient_id").val(patient_data['id']);
        $("#e_name").val(patient_data['name']);
        $("#e_ar_name").val(patient_data['ar_name']);
        $("#e_email").val(patient_data['email']);
        $("#e_phone").val(patient_data['phone']);
        $("#e_birthday").val(patient_data['birthday']);
        $("#e_address").val(patient_data['address']);
    });


    $("#patient_update_btn").click(function(e){
        e.preventDefault();
        var id = $("#e_patient_id").val();
        var name = $("#e_name").val();
        var ar_name = $("#e_ar_name").val();
        var email = $("#e_email").val();
        var birthday = $("#e_birthday").val();
        var phone = $("#e_phone").val();
        var address = $("#e_address").val();
        if(name != "" && email != "" ) {
            $.ajax({
                url: '{{route("reception.patient.store")}}',
                type:"PUT",
                data:{
                    id: id,
                    name: name,
                    ar_name: ar_name,
                    email: email,
                    birthday: birthday,
                    phone: phone,
                    address: address,
                    _token: "{{ csrf_token() }}",
                },
                success:function(response){
                    $("#edit_patient_modal").modal('hide');
                    window.location.href = '{{route("reception.patient")}}';
                },
            });
        }
    });


});
function delete_func(val) {
        document.getElementById(val).submit();
    }
</script>
@endsection
