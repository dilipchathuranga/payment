
@extends('layouts.app')

@section('content')

@if ($result->status=='A')
    <style>
    .all_approve{
            display: none;
        }
    </style>
@else
    <style>
        .all_approve{
                display: block;
            }
    </style>
@endif
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
                    <button class="btn btn-success all_approve"> Approve All Bill</button>
                    <table class="table table-hover" id="account_table" >
                        <thead>
                            <tr>
                                <th style="display:none;">Schedule ID</th>
                                <th style="display:none;">p_scheduleid</th>
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
                    <table class="table table-bordered" id="tbl_schedule">
                        <thead>
                            <tr>
                                <th style="width:20%">Date</th>
                                <th style="width:30%">Refference No</th>
                                <th style="width:20%">Status</th>
                                <th style="width:30%">Action</th>
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


    });

    //Data Table show
    function show_schedules(){
            $('#tbl_schedule').DataTable().clear();
            $('#tbl_schedule').DataTable().destroy();

            $("#tbl_schedule").DataTable({
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
                                html+= "Approved";
                            }else{
                                html+= "Pending";
                            }

                            return html;

                        }
                    },

                    {
                    data: null,
                    render: function(d){
                        var html = "";
                        html+="<td><button class='btn btn-warning btn-sm view_bill' data='"+d.id+"' title='View Payment Bills'><i class='fa fa-sitemap'></i></button>";
                        return html;

                    }

                    }
                ]
            });
    }

    $(document).on('click', '.view_bill', function(){

    var id = $(this).attr('data');
        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'payment_schedule/view_payemt_bill/'+id,
            'async': false,
            success: function(){
                show_account_table(id);
                $("#modal1").modal('show');

            }

        });
    });

    function show_account_table(id){

        $('#account_table').DataTable().clear();
        $('#account_table').DataTable().destroy();

        $("#account_table").DataTable({
            'processing': true,
            'serverSide': true,
            "autoWidth": false,
            "bLengthChange": false,
            'ajax': {
                'method': 'get',
                'url': 'payment_schedule/view_payemt_bill/'+id,
            },
                'columns': [
                    {data: 'schedule_id',"visible": false},
                    {data: 'p_scheduleid',"visible": false},
                    {data: 'module'},
                    {data: 'invoice_date'},
                    {data: 'project_name'},
                    {data: 'supplier_name'},
                    {data: 'amount'},
                    {
                     data: null,
                        render: function(d){
                            var html = "";
                            if(d.bill_status=='A'){
                                html+= "<i class='fas fa-check' style='color:green;margin-top: 10px;'></i> <b style='color:green'> Approved</b>";
                            }else{
                                html+="&nbsp;<button class='btn btn-danger btn-sm delete' data='"+d.schedule_id+"'title='Delete'><i class='fas fa-trash'></i></button>";
                            }

                            return html;

                        }

                    },
                ]
        });
    }

    $(document).on('click', '.all_approve', function(){
       var acc_tables=$('#account_table').DataTable().column(0).data().toArray();
       var p_scheduleid=$('#account_table').DataTable().column(1).data().toArray();


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
                            'data':{acc_tables:acc_tables,p_scheduleid:p_scheduleid},
                            success: function(data){

                                if(data){
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

    $(document).on('click', '.view_bill', function(){

        var id = $(this).attr('data');
            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'get',
                'url': 'payment_schedule/show_approve/'+id,
                'async': false,
                success: function(){

                }

            });
    });


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
