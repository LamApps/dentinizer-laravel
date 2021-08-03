@extends('layouts/layoutMaster')

@section('title', 'Patient Lists')

@section('vendor-style')
<!-- vendor css files -->
<link href="{{ asset('assets/css/libs/jstree.css?ver=2.3.0') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
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
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabOverview"><i
                                class="icon-event_note nav-icon"></i><span>Overview</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="procedures" data-toggle="tab" href="#tabProcedures"><i
                                class="icon-event_note nav-user"></i><span>Procedures</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#"><i
                                class="icon-event_note nav-user"></i><span>Notes</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabBilling"><i
                                class="icon-event_note nav-user"></i><span>Billing</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabStorage"><i
                                class="icon-event_note nav-user"></i><span>Storage</span></a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="tabOverview">

                        <div class="row">
                            <div class="col-md-4">

                                <div class="d-flex flex-row bd-highlight mb-2">
                                    <div class="p-2 bd-highlight">
                                        <div class="avatar bg-light-primary avatar-lg">
                                            <span class="avatar-content">{{ $short_name }}</span>
                                        </div>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <p class="lead-text">{{ $patient_data[0]->name }}</p>
                                        <p class="sub-text">{{ $patient_data[0]->email }}</p>
                                    </div>
                                </div>

                                <h6 class="overline-title-alt">Birthday: <small>{{ $patient_data[0]->email }}</small></h6>
                                <h6 class="overline-title-alt">Phone: <small>{{ $patient_data[0]->phone }}</small></h6>
                                <h6 class="overline-title-alt">Address: <small>{{ $patient_data[0]->address }}</small></h6>

                            </div>
                            <div class="col-md-8">
                            <h4 class="nk-block-title mt-2">Personal Information</h4>
                            <p>Basic info, like your name and address, that you Nio Platform.</p>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="tabProcedures">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">

                                    <div class="d-flex flex-row bd-highlight links flex-center">
                                        @foreach($services as $service)
                                        <div class="p-2 bd-highlight"><a href="#" class="btn btn-outline-warning" style="border-radius: 15px; border-color: #ffc107 !important;">{{ $service->name }}</a></div>
                                        @endforeach
                                    </div>
                                    @if(count($services) == 0 )
                                    <div class="links flex-center">
                                        <h5 class='text-success'>No services.</h5>
                                    </div>
                                    @endif

                                    <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(18)">
                                                    <img src="{{ asset('assets/tooth_images/18.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>18</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(17)">
                                                    <img src="{{ asset('assets/tooth_images/17.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>17</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(16)">
                                                    <img src="{{ asset('assets/tooth_images/16.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>16</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(15)">
                                                    <img src="{{ asset('assets/tooth_images/15.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>15</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(14)">
                                                    <img src="{{ asset('assets/tooth_images/14.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>14</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(13)">
                                                    <img src="{{ asset('assets/tooth_images/13.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>13</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(12)">
                                                    <img src="{{ asset('assets/tooth_images/12.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>12</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(11)">
                                                    <img src="{{ asset('assets/tooth_images/11.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>11</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(21)">
                                                    <img src="{{ asset('assets/tooth_images/11.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>21</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(22)">
                                                    <img src="{{ asset('assets/tooth_images/12.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>22</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(23)">
                                                    <img src="{{ asset('assets/tooth_images/13.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>23</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(24)">
                                                    <img src="{{ asset('assets/tooth_images/14.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>24</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(25)">
                                                    <img src="{{ asset('assets/tooth_images/15.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>25</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(26)">
                                                    <img src="{{ asset('assets/tooth_images/16.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>26</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(27)">
                                                    <img src="{{ asset('assets/tooth_images/17.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>27</p>
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(28)">
                                                    <img src="{{ asset('assets/tooth_images/18.svg') }}" alt=""
                                                        class="img-fluid">
                                                    <p>28</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(48)">
                                                    <p>48</p>
                                                    <img src="{{ asset('assets/tooth_images/48.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(47)">
                                                    <p>47</p>
                                                    <img src="{{ asset('assets/tooth_images/47.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(46)">
                                                    <p>46</p>
                                                    <img src="{{ asset('assets/tooth_images/46.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(45)">
                                                    <p>45</p>
                                                    <img src="{{ asset('assets/tooth_images/45.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(44)">
                                                    <p>44</p>
                                                    <img src="{{ asset('assets/tooth_images/44.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(43)">
                                                    <p>43</p>
                                                    <img src="{{ asset('assets/tooth_images/43.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(42)">
                                                    <p>42</p>
                                                    <img src="{{ asset('assets/tooth_images/42.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(41)">
                                                    <p>41</p>
                                                    <img src="{{ asset('assets/tooth_images/41.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item flip" onClick="openmodal(31)">
                                                    <p>31</p>
                                                    <img src="{{ asset('assets/tooth_images/41.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(32)">
                                                    <p>32</p>
                                                    <img src="{{ asset('assets/tooth_images/42.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(33)">
                                                    <p>33</p>
                                                    <img src="{{ asset('assets/tooth_images/43.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(34)">
                                                    <p>34</p>
                                                    <img src="{{ asset('assets/tooth_images/44.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(35)">
                                                    <p>35</p>
                                                    <img src="{{ asset('assets/tooth_images/45.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(36)">
                                                    <p>36</p>
                                                    <img src="{{ asset('assets/tooth_images/46.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(37)">
                                                    <p>37</p>
                                                    <img src="{{ asset('assets/tooth_images/47.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <div class="item" onClick="openmodal(38)">
                                                    <p>38</p>
                                                    <img src="{{ asset('assets/tooth_images/48.svg') }}" alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Teeth ID</th>
                                                        <th>Service Name</th>
                                                        <th>Note</th>
                                                        <th>Price</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($services as $service)
                                                    <tr>
                                                        <td><span>{{ $service->teeth_id }}</span></td>
                                                        <td><span>{{ $service->name }}</span></td>
                                                        <td><span>{{ $service->note }}</span></td>
                                                        <td><span>{{ $service->price }}</span></td>
                                                        <td><span>{{ $service->type }}</span></td>
                                                        <!-- <td class="text-center">
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button"   data-toggle="modal" data-target="#view_notemodal"  data-id="{{ json_encode($service) }}"  class="btn btn-info">
                                                                        <i class="icon-edit1"></i>
                                                                    </button>
                                                                    <button onclick="delete_func('delete_frm_{{ $service->id }}')"  type="button" class="btn btn-danger">
                                                                        <form action="{{ route('admin.patient_profile.destroy', $service->id)}}" name="delete_frm_{{ $service->id }}" id="delete_frm_{{ $service->id }}" method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <i class="icon-cancel"></i>
                                                                        </form>
                                                                    </button>    
                                                                                                    
                                                                </div>                                         
                                                            </td> -->
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

                    <div class="tab-pane" id="tabBilling">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>From</th>
                                                        <th>To</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($invoices as $invoice)
                                                    <tr>
                                                        <td><span>{{ $invoice->code }}</span></td>
                                                        <td><span>{{ $invoice->d_email }}</span></td>
                                                        <td><span>{{ $invoice->p_email }}</span></td>
                                                        <td><span>{{ $invoice->amount }}</span></td>
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

                    <div class="tab-pane" id="tabStorage">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Description</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($storages as $storage)
                                                    <tr>
                                                        <td><span>{{ $storage->title }}</span></td>
                                                        <td><span>{{ $storage->description }}</span></td>

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

                </div>
            </div>
        </div>
    </div>
</div>

<!-- @@ Add Modal @e -->
<div class="modal fade bd-example-modal-lg" id="notemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body modal-body-lg">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row gy-4">
                            <input type="hidden" id="sel_category" value="0">
                            <div class="col-md-3">
                                <div id="context-menu-tree">
                                    <ul>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <input type="hidden" id="teeth_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cf-default-textarea">Note</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-sm" name="note" id="note"
                                                    cols="30" rows="6" placeholder="Enter Note"
                                                    required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li class="text-right">
                                                <a href="#" class="btn btn-lg btn-primary" id="note_save_btn"><i data-feather="save"></i> Save</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->



<!-- @@ View Modal @e -->
<div class="modal fade bd-example-modal-lg" id="view_notemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body modal-body-lg">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row gy-4">
                            <input type="hidden" id="profile_id" value="0">
                            <input type="hidden" id="sel_category" value="0">
                            <div class="col-md-3">
                                <div id="context-menu-tree">
                                    <ul>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <input type="hidden" id="teeth_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="cf-default-textarea">Note</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control form-control-sm" name="note" id="note"
                                                    cols="30" rows="6" placeholder="Enter Note"
                                                    required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                    <li class="text-right">
                                        <a href="#" class="btn btn-lg btn-primary" id="note_save_btn"><i data-feather="save"></i> Save</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection

@section('vendor-script')
<script src="{{ asset('assets/js/libs/jstree.js?ver=2.3.0') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
@endsection
@section('page-script')
<script>
function openmodal(id) {
    clear();
    $("#notemodal").modal("show");
    $("#notemodal #modalTitle").text(id);
    $("#notemodal #teeth_id").val(id);
}


$("#notemodal  #context-menu-tree").jstree({
    "core": {
        "data": {!!$datas!!},
        "themes": {
            "responsive": false
        },
        "check_callback": true
    },
    "plugins": ["contextmenu"],
    "contextmenu": {
        "items": function($node) {

        }
    }
});


$("#notemodal  #context-menu-tree").bind("changed.jstree", function(e, data) {
    $("#notemodal  #sel_category").val(data.node.id);
    //alert("Checked: " + data.node.id);
    // alert("Parent: " + data.node.parent);    
});



$("#notemodal #note_save_btn").click(function(e) {
    e.preventDefault();
    var teeth_id = $("#notemodal #teeth_id").val();
    var notes = $("#notemodal #note").val();
    var category = $("#notemodal #sel_category").val();

    if (notes != "" && category != "0") {
        $.ajax({
            url: '{{ route("admin.patient.profilestore" )}}',
            type: "POST",
            data: {
                patient_id: {{$patient_id}},
                category: category,
                teeth_id: teeth_id,
                notes: notes,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $("#notemodal").modal("hide");
                if (response['state']['id'] >= 1) {
                    swal({
                        title: "Success!",
                        text: 'New note created successfully.',
                        icon: "success",
                    });
                } else if (response['state']['id'] < 1) {
                    swal({
                        title: "Waring!",
                        text: "Failed",
                        icon: "error",
                    });
                }
                clear();
                location.reload();
            },
        });
    } else {
        swal({
            title: "Waring!",
            text: "Please select category and type note.",
            icon: "error",
        });
    }
});




function clear() {
    $("#notemodal #modalTitle").text("");
    $("#notemodal #teeth_id").val("");
    $("#notemodal #note").val("");
}




$('#view_notemodal').on('show.bs.modal', function(e) {

    var tmp = $('#view_notemodal #context-menu-tree').jstree(true);
    if (tmp) {
        tmp.destroy();
    }

    var service_data = $(e.relatedTarget).data('id');

    $("#view_notemodal #profile_id").val(service_data['id']);
    $("#view_notemodal #modalTitle").text(service_data['teeth_id']);
    $("#view_notemodal #teeth_id").val(service_data['teeth_id']);
    $("#view_notemodal #sel_category").val(service_data['category_id']);
    $("#view_notemodal #note").val(service_data['note']);

    var e_c_datas = {!!$datas!!};

    var state_child = {
        opened: true, // is the node open
        disabled: false, // is the node disabled
        selected: true // is the node selected
    };

    var state_parent = {
        opened: true, // is the node open
        disabled: false, // is the node disabled
        selected: false // is the node selected
    };

    for (var i = 0; i < e_c_datas.length; i++) {

        if (e_c_datas[i].id == service_data['category_id']) {
            e_c_datas[i].state = state_child;
        } else {
            e_c_datas[i].state = state_parent;
        }
    };


    $("#view_notemodal #context-menu-tree").jstree({
        "core": {
            "data": e_c_datas,
            "themes": {
                "responsive": false
            },
            "check_callback": true
        },
        "plugins": ["contextmenu"],
        "contextmenu": {
            "items": function($node) {

            }
        }
    });

    $("#view_notemodal  #context-menu-tree").bind("changed.jstree", function(e, data) {
        $("#view_notemodal  #sel_category").val(data.node.id);
        //alert("Checked: " + data.node.id);
        // alert("Parent: " + data.node.parent);    
    });

});



$("#view_notemodal #note_save_btn").click(function(e) {
    e.preventDefault();
    var teeth_id = $("#view_notemodal #teeth_id").val();
    var notes = $("#view_notemodal #note").val();
    var category = $("#view_notemodal #sel_category").val();

    if (notes != "" && category != "0") {
        $.ajax({
            url: '{{ route("admin.patient.profilestore" )}}',
            type: "POST",
            data: {
                id: $("#view_notemodal #profile_id").val(),
                patient_id: {{$patient_id}},
                category: category,
                teeth_id: teeth_id,
                notes: notes,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $("#view_notemodal #notemodal").modal("hide");
                if (response['state']['id'] >= 1) {
                    swal({
                        title: "Success!",
                        text: 'New note created successfully.',
                        icon: "success",
                    });
                } else if (response['state']['id'] < 1) {
                    swal({
                        title: "Waring!",
                        text: "Failed",
                        icon: "error",
                    });
                }
                clear();
                location.reload();

            },
        });
    } else {
        swal({
            title: "Waring!",
            text: "Please select category and type note.",
            icon: "error",
        });
    }
});

function delete_func(val) {
    document.getElementById(val).submit();
}
</script>
@endsection












