@extends('layouts.app')

@section('content')

<script>

    // function delete_func(val) {
    //     document.getElementById(val).submit();
    // }

    function delete_row(e, price) {              //Add e as parameter
      $(e).parents('tr').remove();   //Use the e to delete
      var totoal_price =  parseInt($("#a_total").val(), 10);
      totoal_price = totoal_price - parseInt(price, 10);
      $("#a_total").val(totoal_price);
    }

</script>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Invoice Lists</li>
    </ol>
</div>

<div class="content-wrapper">  
    
    <div class="row mb-2">    
        <div class="col-md-10"></div>
        <div class="col-md-2 text-right">
            <a href="#" id="new_modal_btn" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#add_invoice_modal"><span class="icon-plus1">Create Quick Invoice</span></a>
        </div>  
    </div> 
    
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table"> 
                        <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr onClick = "window.location.href = 'invoice/{{$appointment->patient_id}}/{{$appointment->doctor_id}}'" style="cursor: url(hand.cur), pointer">
                                        <td><span>{{ $appointment->d_email }}</span></td>
                                        <td><span>{{ $appointment->p_email }}</span></td>
                                        <td><span>{{ $appointment->start_time }}</span></td>
                                        <td><span>{{ $appointment->duration }}</span></td>                        
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
                <button  class="btn btn-primary" id="invoice_save_btn"><span class="icon-save"></span>&nbsp;Save</button>                                        
                <button  data-dismiss="modal" class="btn btn-danger"><span class="icon-close"></span>&nbsp;Cancel</button>                                            
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>



<script>
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

@endsection
