
@extends('layouts.app')

@section('content')

<!-- view payment bill modal -->
<div class="modal fade " id="modal1" >
    <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content" >
        <div class="modal-header">
            <h5 class="modal-title">Payment Bills</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="card card-outline card-warning">
                <div class="card-body">
                    <button class="btn btn-success all_approve" style="display:none"> Approve all Bills</button>
                    <table class="table table-hover" id="account_table" >
                        <thead>
                            <tr>
                                <th style="display:none;">Schedule ID</th>
                                <th style="display:none;">p_schedule_id</th>
                                <th style="font-size: 12px;">Module</th>
                                <th style="font-size: 12px;">Invoice Date</th>
                                <th style="font-size: 12px;">Project</th>
                                <th style="font-size: 12px;">Supplier</th>
                                <th style="font-size: 12px;">Amount</th>
                                <th style="font-size: 12px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="m-0 text-dark">Payment Schedule</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Payment Section</a></li>
              <li class="breadcrumb-item active">Payment Schedule</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- <button class="btn btn-primary addNew"><i class="fa fa-plus"></i> Add New Schedule</button> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                                &nbsp;
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm float-right">
                            <select name="status" id="status" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                <option value="">-- search by status --</option>
                                <option value="P">Pending</option>
                                <option value="A">Approved</option>
                                <option value="C">Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm float-right">
                                <input type="text" class="form-control datepicker float-right" name="date" id="date"  placeholder="Search by Invoice Date" value="" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered" id="tbl_schedule">
                        <thead>
                            <tr>
                                <th style="width:20%">Date</th>
                                <th style="width:30%">Refference No</th>
                                <th style="width:20%">Status</th>
                                <th style="width:30%">Action</th>
                                <th style="width:10%">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var acc_table;
    $(document).ready(function(){

        // menu active
        $(".schedule_route").addClass('active');

        //csrf token error
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        show_schedules();

        $(document).on("blur",".form-control",function(){
            $("#submit").css("display","block");
        });

        $("#date").datepicker( {
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                orientation: 'bottom'
        });
    });

    //Data Table show
    function show_schedules(){
        
            $('#tbl_schedule').DataTable().clear();
            $('#tbl_schedule').DataTable().destroy();

            shedule=$("#tbl_schedule").DataTable({
                'processing': true,
                'serverSide': true,
                "bLengthChange": false,
                'ajax': {
                            'method': 'get',
                            'url': 'payment_schedule/create'
                },
                'columns': [
                    {data: 'date'},
                    {data: 'refference_no'},
                    {
                        data: null,
                        render: function(d){
                            var html = "";
                            if(d.status=='A'){
                                html = "<span style='padding:5px' class='badge badge-primary' >Approved</span>";
                            }if(d.status=='P'){
                                html = "<span style='padding:5px' class='badge badge-warning'>Pending</span>";
                            }if(d.status=='C'){
                                html = "<span style='padding:5px' class='badge badge-success' data='C'>Paid</span>";
                            }
                            return html;

                        }
                    },

                    {
                    data: null,
                    render: function(d){
                        var html = "";
                        html+="<td><button class='btn btn-warning btn-sm view_bill' data='"+d.id+"' title='View Payment Bills'><i class='fa fa-sitemap'></i></button>";
                            if(d.status=='A'){
                                html+="&nbsp;<button class='btn btn-success btn-sm pay' data='"+d.id+"' title='Bill Pay'><i class='fas fa-money-bill'></i></button>";
                            }
                            if(d.status=='C'){
                                html+="&nbsp;<button class='btn btn-success btn-sm excel' data='"+d.id+"' data-ref='"+d.refference_no+"' title='Excel Download'><i class='fas fa-file-excel'></i></button>";
                            }

                        return html;

                    }

                    },
                    {data: 'status', "visible": false}

                ]
            });

            $(document).on('change', '#date', function(){
                    var value = $(this).val();

                    if(value!= ""){
                        shedule.columns(0).search(value).draw();
                    }else{
                        shedule.columns(0).search("").draw();
                    }
            });
            $(document).on('change', '#status', function(){

                var value = $(this).val();
                if(value!= ""){
                    shedule.columns(4).search(value).draw();
                }else{
                    shedule.columns(4).search("").draw();
                }
            });
    }

    $(document).on('click', '.view_bill', function(){

        var id = $(this).attr('data');
     
        $("#modal1").modal('show');
        
        // check if all bills are approved
        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'payment_schedule/check_schedule/'+id,
            'async': false,
            success: function(data){
    
                if(data == true){
                    $(".all_approve").css("display", "block");
                }else{
                    $(".all_approve").css("display", "none");
                }
            
            }
        });
        
    
        $('#account_table').DataTable().clear();
        $('#account_table').DataTable().destroy();

        $("#account_table").DataTable({
            'processing': true,
            'serverSide': true,
            "autoWidth": false,
            "bLengthChange": false,
            'ajax': {
                'method': 'get',
                'url': 'payment_schedule/view_payment_bill/'+id,
            },
                'columns': [
                    {data: 'schedule_id',"visible": false},
                    {data: 'p_schedule_id',"visible": false},
                    {data: 'module'},
                    {data: 'invoice_date'},
                    {data: 'project_name'},
                    {data: 'supplier_name'},
                    {data: 'amount'},
                    {
                     data: null,
                        render: function(d){
                            var html = "";
                            if((d.bill_status=='A')||(d.bill_status=='C')){
                                html+= "<i class='fas fa-check' style='color:green;margin-top: 10px;'></i> <b style='color:green'> Approved</b>";
                            }else{
                                html+="&nbsp;<button class='btn btn-danger btn-sm delete' data='"+d.schedule_id+"'title='Delete'><i class='fas fa-trash'></i></button>";
                            }

                            return html;

                        }

                    },
                ]
        });
            
    });


    $(document).on('click', '.all_approve', function(){
        
       var acc_tables = $('#account_table').DataTable().column(0).data().toArray();
       var p_schedule = $('#account_table').DataTable().column(1).data().toArray();
       
       var p_schedule_id = p_schedule[0];

    

       Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            'type': 'ajax',
                            'dataType': 'json',
                            'method': 'put',
                            'url': 'payment_schedule/add_all_approve',
                            'async': false,
                            'data':{acc_tables:acc_tables,p_schedule_id:p_schedule_id},
                            success: function(data){

                                if(data){
                                    $(".all_approve").css("display", "none");
                                    toastr.success(data.db_success);
                                    setTimeout(function(){
                                        $('#account_table').DataTable().ajax.reload();
                                        $('#tbl_schedule').DataTable().ajax.reload();

                                    }, 1000);

                                }

                            }
                        });

                    }
        });

    });

    $(document).on('click', '.pay', function(){
        var id = $(this).attr('data');

       Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Pay it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            'type': 'ajax',
                            'dataType': 'json',
                            'method': 'put',
                            'url': 'payment_schedule/pay/'+id,
                            'async': false,
                            success: function(data){
                                excel_sheet(id);

                                if(data){
                                    toastr.success(data.db_success);
                                    setTimeout(function(){
                                        $('#tbl_schedule').DataTable().ajax.reload();
                                    }, 1000);

                                }

                            }
                        });

                    }

        });

    });


    $(document).on('click', '.excel', function(){

        var id = $(this).attr('data');
        var ref = $(this).attr('data-ref');

        Swal.fire({
                title: 'Are you sure?',
                text: "You won't to download this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Download it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        excel_sheet(id);
                    }

                });

    });

    function excel_sheet(id){
            window.open('bill_export/'+id, '_blank')
    }

    //pending delete payment bills
    $(document).on('click', '.delete', function(){

        var id = $(this).attr('data');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        'type': 'ajax',
                        'dataType': 'json',
                        'method': 'get',
                        'url': 'payment_schedule/delete/'+id,
                        'async': false,
                        success: function(data){

                        if(data){
                            toastr.success(data.db_success);
                            setTimeout(function(){
                                $('#account_table').DataTable().ajax.reload();
                            }, 500);

                        }

                        }
                    });

                }

        });
    });

    function validation_error(error){
        for(var i=0;i< error.length;i++){
            Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error[i],
            });
        }
    }

    function db_error(error){
        Swal.fire({
            icon: 'error',
            title: 'Database Error',
            text: error,
        });
    }

    function db_success(message){
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
        });
    }
</script>
@endsection
