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
        <div class="col-md-10">
            <h5 class='text-success'>You have total {{ count($invoices) }} Invoices.</h5>
        </div>
        <div class="col-md-2 text-right">
            <a href="#" id="new_modal_btn" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#add_invoice_modal"><span class="icon-plus1"></span></a>
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
                                    <th>Code</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td><span>{{ $invoice->code }}</span></td>
                                    <td><span>{{ $invoice->d_email }}</span></td>
                                    <td><span>{{ $invoice->p_email }}</span></td>
                                    <td><span>{{ $invoice->amount }}</span></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button"  data-toggle="modal" data-target="#view_invoice_modal"  data-id="{{ json_encode($invoice) }}" class="btn btn-info">
                                                <i class="icon-eye"></i>
                                            </button>                                                                                    
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
                                <select class="selectpicker form-control form-control-lg" data-search="on" id="a_from" name="a_from">
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">To</label>
                            <div class="form-control-wrap">
                                <select class="selectpicker form-control form-control-lg" data-search="on" id="a_to" name="a_to">
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" id="a_description" name="a_description" class="form-control form-control-lg"  placeholder="Enter description">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="1" max="9999999999" id="a_price" name="a_price" class="form-control form-control-lg" placeholder="Price">
                                <div class="input-group-append">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="form-control-wrap text-right">
                                <a href="#" id="new_btn" name="new_btn" class="btn btn-primary" style="margin-top: 5px;"><span class="icon-plus1"></span></a>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table" style="border:1px solid #eee" id = "bill_tbl" name = "bill_tbl">
                            <thead class="table" >
                                <tr>
                                    <th><span class="overline-title">Description</span></th>
                                    <th><span class="overline-title">Amount</span></th>
                                    <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                </tr>
                            </thead>
                            <tbody id="add_tbody">
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="0" max="9999999999" id="a_total" name="a_total" value = "0" class="form-control form-control-lg" readonly>
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
<!-- @@ Add Modal @e -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="view_invoice_modal">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div  class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">View Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="title text-right" id="v_code"></h5>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">From</label>
                            <div class="form-control-wrap">
                                <select class="selectpicker form-control form-control-lg" data-search="on" id="v_from" name="v_from" readonly>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">To</label>
                            <div class="form-control-wrap">
                                <select class="selectpicker form-control form-control-lg" data-search="on" id="v_to" name="v_to" readonly>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table" style="border:1px solid #eee" id = "v_bill_tbl" name = "v_bill_tbl">
                            <thead >
                                <tr>
                                    <th><span class="overline-title">Description</span></th>
                                    <th><span class="overline-title">Amount</span></th>
                                </tr>
                            </thead>
                            <tbody id="add_tbody">
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="0" max="9999999999" id="v_total" name="v_total" value = "0" class="form-control form-control-lg" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Totoal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->            
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->





<script>
$(document).ready(function(){

    var table = $('.datatable').DataTable();
    $('#new_modal_btn').on('click', function(e) {
        var time = new Date().getTime(); 
        $('#code').text("#" + time.toString());    
    });

    
    var lineNo = 1;
    $('#new_btn').on('click', function(e) {
        var description = $("#a_description").val();
        var price = $("#a_price").val();
        if(description != "" && price != "") {

            var markup = "<tr id = 'tr_" + lineNo + "'>"
                            +"<td>" + description + "</td>"
                            +"<td>" + price + "</td>"
                            +"<td  class='tb-col-action'><a onclick='delete_row(this, " + price + ")' class='link-cross mr-sm-n1'><span class='icon-close'></span></a></td>"
                        +"</tr>"; 
                tableBody = $("#bill_tbl tbody"); 
                tableBody.append(markup); 
                var total_price = parseInt($("#a_total").val(), 10);
                total_price = total_price + parseInt(price, 10);
                $("#a_total").val(total_price);

                lineNo++; 
        } else {
            Swal.fire("Error!", "Please type description and price!", "error");
            e.preventDefault();
        }
    });



    $("#invoice_save_btn").on('click', function(e) {
        var code  = $('#code').text();
        var from = $("#a_from").val();
        var to = $("#a_to").val();

        if( from != "" && to != "" ) {
            $.ajax({
                url: '{{route("reception.invoice.store")}}',
                type:"POST",
                data:{
                    code: code,
                    from: from,
                    to: to,
                    _token: "{{ csrf_token() }}",
                },
                success:function(response){
                    //$("#add_invoice_modal").modal('hide');
                    //NioApp.Toast('Success.', 'success');
                    //toastr.clear();
                    //window.location.href = '{{route("reception.invoice")}}';

                    var html_table_data = "";  
                    var bRowStarted = true;  
                    var temp_arr = Array();
                    var tbody_arr = Array();
                    $('#add_tbody>tr').each(function () {  
                        temp_arr =  [];
                        $('td', this).each(function () {  
                            if (html_table_data.length == 0 || bRowStarted == true) {  
                                html_table_data += $(this).text();  
                                bRowStarted = false; 
                                temp_arr.push($(this).text());
                            }  
                            else {
                                html_table_data += " | " + $(this).text(); 
                                temp_arr.push($(this).text());
                            }
                                
                        }); 
                        tbody_arr.push(temp_arr);
                        html_table_data += "\n";  
                        bRowStarted = true;  
                    });  


                    $.ajax({
                        url: '{{route("reception.invoice.liststore")}}',
                        type:"POST",
                        data:{
                            code: code,
                            listdata: JSON.stringify(tbody_arr),
                            _token: "{{ csrf_token() }}",
                        },
                        success:function(response){
                            $("#add_invoice_modal").modal('hide');
                            NioApp.Toast('Success.', 'success');
                            toastr.clear();
                            window.location.href = '{{route("reception.invoice")}}';
                        },
                    });

                },
            });
        }


    
    });



    $('#view_invoice_modal').on('show.bs.modal', function(e) {
        var invoice_list_data = $(e.relatedTarget).data('id');
        $('#v_code').text(invoice_list_data['code']);    
        $("#v_total").val(invoice_list_data['amount']);

        $("#v_from").val(invoice_list_data['from']);
        $('#select2-v_from-container').text(invoice_list_data['d_email']);

        $("#v_to").val(invoice_list_data['to']);
        $('#select2-v_to-container').text(invoice_list_data['p_email']);

        var url = "/reception/invoice/" + invoice_list_data['code'].substring(1);
        $.ajax({
            url: url,
            type:"GET",
            dataType: 'json',
            success:function(response){
                $("#v_bill_tbl tbody").empty();
                
                response.forEach(function(element) {
                    var markup_tbl = "<tr>"
                            +"<td>" + element.description + "</td>"
                            +"<td>" + element.amount + "</td>"
                        +"</tr>"; 
                    $("#v_bill_tbl tbody").append(markup_tbl); 
                })
                
            },
        });

    });
    


});
</script>

@endsection
