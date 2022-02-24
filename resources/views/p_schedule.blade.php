@extends('layouts.app')

@section('content')
<!-- view payment bill modal -->
<div class="modal fade " id="modal1" >
    <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content" >
        <div class="modal-header">
            <h5 class="modal-title">View Payment Bills</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card card-outline card-danger">
                <div class="card-body">

                    <table class="table table-hover" id="account_table" >
                        <thead>
                            <tr>
                                <th style="font-size: 12px;">Module</th>
                                <th style="font-size: 12px;">Invoice Date</th>
                                <th style="font-size: 12px;">Project</th>
                                <th style="font-size: 12px;">Supplier</th>
                                <th style="font-size: 12px;">Amount</th>
                                <th style="font-size: 12px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                <th style="width:50%">Refference No</th>
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
                        html+="<td><button class='btn btn-warning btn-sm view_bill' data='"+d.id+"'>View Payment Bills</button>";
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

    function show_account_table(id)
    {
        acc_table=$('#account_table').DataTable().clear();
        $('#account_table').DataTable().destroy();

        $("#account_table").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            'ajax': {
                'method': 'get',
                'url': 'payment_schedule/view_payemt_bill/'+id,
            },
                'columns': [
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
                                html+="<td><button class='btn btn-success btn-sm approve' title='Approve' data='"+d.id+"'><i class='fas fa-check-circle'></i></button>";
                            }
                            if(d.bill_status=='A')
                            {
                                html+="&nbsp;<button class='btn btn-info btn-sm pending' data='"+d.id+"'title='Pending'><i class='fas fa-spinner'></i></button>";
                            }
                            return html;

                        }

                    }
                ]
        });
    }


    //approve  add view payment bills
    $(document).on('click', '.approve', function(){

            var id = $(this).attr('data');

        Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            'type': 'ajax',
                            'dataType': 'json',
                            'method': 'put',
                            'url': 'payment_schedule/approve/'+id,
                            'async': false,
                            success: function(data){

                            if(data){
                                toastr.success('Bill Status Changed');
                                setTimeout(function(){
                                    $('#account_table').DataTable().ajax.reload();
                                }, 500);

                            }

                            }
                        });

                    }

        });
    });

    //pending  add view payment bills
    $(document).on('click', '.pending', function(){

        var id = $(this).attr('data');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        'type': 'ajax',
                        'dataType': 'json',
                        'method': 'put',
                        'url': 'payment_schedule/pending/'+id,
                        'async': false,
                        success: function(data){

                        if(data){
                            toastr.success('Bill Status Changed');
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
