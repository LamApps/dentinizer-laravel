@extends('layouts.app')

@section('content')


<script>

    function complete_func(val) {
        document.getElementById(val).submit();
    }

</script>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Patient Lists</li>
    </ol>
</div>



<div class="content-wrapper">  
    <div class="row mb-2">    
        <div class="col-md-10">
           
        </div>
        <div class="col-md-2 text-right">
            <a href="#" id="new_modal_btn" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#add_invoice_modal"><span class="icon-plus1">Create Invoice</span></a>
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
                                    <th class="nk-tb-col nk-tb-col-check">
                                        
                                    </th>
                                    <th>From</th>
                                    <th>Duration</th>
                                    <th>Patient Name</th>
                                    <th>Patient Email</th>
                                    <th>Teeth ID</th>
                                    <th>Service</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th class="tb-tnx-action">
                                        Action
                                    </th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                                
                            <tbody id="plan_tbody">
                                @foreach(json_decode($plans) as $plan)
                                    <tr>
                                        @if($plan->type == "existing" || $plan->invoiced == 1)
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid{{ $plan->id }}" value = "{{$plan->id}}" disabled>
                                                    <label class="custom-control-label" for="uid{{ $plan->id }}"></label>
                                                </div>
                                            </td>
                                        @else
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input"  value = "{{$plan->id}}" id="uid{{ $plan->id }}">
                                                    <label class="custom-control-label" for="uid{{ $plan->id }}"></label>
                                                </div>
                                            </td>
                                        @endif
                                        <td><span>{{ $plan->start_time }}</span></td>
                                        <td><span>{{ $plan->duration }}</span></td>
                                        <td><span>{{ $plan->p_name }}</span></td>
                                        <td><span>{{ $plan->p_email }}</span></td>
                                        <td><span>{{ $plan->teeth_id }}</span></td>
                                        <td><span>{{ $plan->s_name }}</span></td>
                                        <td><span>{{ $plan->price }}</span></td>
                                        <td><span>{{ $plan->type }}</span></td>
                                        <td>
                                            @if($plan->type != "completed")
                                                <button onclick="complete_func('complete_frm_{{ $plan->id }}')"  type="button" class="btn btn-primary">
                                                    <form action="{{ route('reception.invoice.plan.complete', ['plan_id' => $plan->id, 'patient_id' => $patient[0]->id, 'doctor_id' => $doctor[0]->id ])}}" name="complete_frm_{{ $plan->id }}" id="complete_frm_{{ $plan->id }}" method="post">
                                                        @csrf
                                                        @method('POST')
                                                        Complete
                                                    </form>    
                                                </button>       
                                            @endif
                                        </td>
                                        <td>
                                            @if($plan->invoiced == 1)
                                                <span>Invoiced</span>
                                            @else
                                                <span>UnInvoiced</span>
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



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="add_invoice_modal">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div  class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Add Invoice</h5>
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
                                <input type="text" id="from" name="from" value = "{{ $doctor[0]->email }}" class="form-control form-control-lg" readonly>
                                <input type="hidden" id="from_id" name="from_id" value = "{{ $doctor[0]->id }}" class="form-control form-control-lg" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">To</label>
                            <div class="form-control-wrap">
                                <input type="text" id="to" name="to"  value = "{{ $patient[0]->email }}" class="form-control form-control-lg" readonly>
                                <input type="hidden" id="to_id" name="to_id" value = "{{ $patient[0]->id }}" class="form-control form-control-lg" readonly>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <table class="table" style="border:1px solid #eee" id = "bill_tbl" name = "bill_tbl">
                            <thead class="table" >
                                <tr>
                                    <th><span class="overline-title">Teeth ID</span></th>
                                    <th><span class="overline-title">Service</span></th>
                                    <th><span class="overline-title">Amount</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                  
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
</div><!-- .modal -->



<script>
    var save_arr = Array();
    var plan_arr = Array();
    $('#add_invoice_modal').on('show.bs.modal', function(e) {
        save_arr = [];
        plan_arr = [];
        var time = new Date().getTime(); 
        $('#code').text(time.toString());  
        
        $('#plan_tbody [type="checkbox"]').each(function(i, chk) {
            if (chk.checked) {
                plan_arr.push(chk.value);
            }
        });

        $("#bill_tbl tbody").empty();
        var total = 0;
        if(plan_arr.length >= 0 ) {
            {!! $plans !!}.forEach(function(element) {
                plan_arr.forEach(function(arr_element) {
                    if(parseInt(arr_element, 10) == parseInt(element['id'], 10)){
                        if (element['price'] != null )
                            total = total + parseInt(element['price'], 10);
                        var markup_tbl = "<tr>"
                                +"<td>" + element['teeth_id'] + "</td>"
                                +"<td>" + element['s_name'] + "</td>"
                                +"<td>" + element['price'] + "</td>"
                            +"</tr>"; 
                        save_arr.push(element);
                        $("#bill_tbl tbody").append(markup_tbl); 
                    }
                });
            });

            $("#total").val(total);

        }  
    });


    $("#invoice_save_btn").on('click', function(e) {
        $.ajax({
            url: '{{route("reception.invoice.store")}}',
            type:"POST",
            data:{
                code: $("#code").text(),
                from: $("#from_id").val(),
                to: $("#to_id").val(),
                total : $('#total').val(),
                invoices: save_arr,
                invoice_flags: plan_arr,
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
