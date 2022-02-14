@extends('layouts.app')

@section('content')
<style>

    .btn-active{
        background-color: #ddd;
    }

    .table#pending_table  {
        table-layout: fixed;
         width: 100% !important;
    }

    .table#pending_table td {
        font-size: 12px;
    }

    .table#receiving_table  {
        table-layout: fixed;
         width: 100% !important;
    }

    .table#receiving_table td {
        font-size: 12px;
    }

</style>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bulk Bill Receive</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Pending Bills</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover" id="pending_table" >
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
                    <div class="col-md-6">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">Receive Bill</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover" id="receiving_table" >
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
                </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success bill_receive" id="submit">Receive Bills</button>
          </div>
      </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="m-0 text-dark">Payment Bills</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Payment</a></li>
              <li class="breadcrumb-item active">Payment Bills</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   
                    
                    <div class="input-group input-group-sm float-right" style="width: 260px; ">
                      <button class="btn btn-flat btn-default" name="option1" id="option1" > Pending Bills</button>
                      <button class="btn btn-flat btn-default btn-active" name="option2" id="option2" > Recieved Bills</button>
                    </div>
                
                </div>
                <div class="card-body">

                <div class="row">
                  <div class="col-md-6">
                        &nbsp;
                  </div>
                  <div class="col-md-6">
                      <div class="input-group input-group-sm float-right" style="width: 450px; ">
                      <select name="project_id_s" id="project_id_s" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                          <option value="">-- search by project --</option>
                              
                          </select>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                        &nbsp;
                  </div>
                  <div class="col-md-6">
                      <div class="input-group input-group-sm float-right" style="width: 450px; ">
                      <select name="supplier_id_s" id="supplier_id_s" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                          <option value="">-- search by supplier --</option>
                              
                          </select>
                      </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        &nbsp;
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm float-right" style="width: 450px; ">
                            <input type="text" id="table_search" name="table_search" class="form-control float-right" placeholder="Search by Bill Refference No">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-10">
                        &nbsp;
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm float-right" >
                            <button class="btn btn-primary btn-block bulk_receive">Bulk Bill Recieve</button>
                        </div>
                    </div>
                </div>
                <br>
                    <table class="table table-hover" id="dataTable">
                        <thead>                  
                            <tr>
                                <th style="width:10%">Module</th>
                                <th style="width:10%">Project</th>
                                <th style="width:10%">Supplier</th>
                                <th style="width:10%">Invoice Date</th>
                                <th style="width:20%">Bill Refference</th>
                                <th style="width:10%">Amount</th>
                                <!-- <th style="width:10%">More Details</th> -->
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                    <br>
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if(Session::has('bill_session'))
  <input type="hidden" id="bill_session" value="1">
@else
  <input type="hidden" id="bill_session" value="0">
@endif

<script>
    $(document).ready(function(){

        //csrf token error
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //session 
        var bill_session = $("#bill_session").val();
        if(bill_session == '1'){
        show_session_bills();
        
        }else{
        show_pending_bills();
        }

        $("#option1").click(function(){

            var session = 'pending_bill';
            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'post',
                'url': 'home/bill_session',
                'data': {session:session},
                'async': false,
                'success': function(data){
                    
                }
            });
            show_pending_bills();

        });

        $("#option2").click(function(){

            var session = 'received_bill';
            $.ajax({
                    'type': 'ajax',
                    'dataType': 'json',
                    'method': 'post',
                    'url': 'home/bill_session',
                    'data': {session:session},
                    'async': false,
                    'success': function(data){
                    
                    }
            });
            show_received_bills();

        });

        $(".bulk_receive").click(function(){

            $("#modal").modal('show');

            // receiving id array
            var recieving_bill = [];

            // get pending bills
            var pending_bills = get_pending_bills();

            // two tables
            var pending_table;
            var receiving_table;

            // bill pending table 
            $('#pending_table').DataTable().clear();
            $('#pending_table').DataTable().destroy();

            pending_table = $("#pending_table").DataTable({
                "paging": false,
                "searching": false,
                "pageLength": 20,
                fixedColumns: true

            });

            // bill receiving table
            $('#receiving_table').DataTable().clear();
            $('#receiving_table').DataTable().destroy();

            receiving_table=$("#receiving_table").DataTable({
                "paging": false,
                "searching": false,
                "pageLength": 20,
                fixedColumns: true
                
            });

            //add pending table data
            if(pending_bills.length > 0){
                for(var i=0; i < pending_bills.length; i++){

                    pending_table.row.add([pending_bills[i].module,
                        pending_bills[i].invoice_date,
                        pending_bills[i].project_name,
                        pending_bills[i].supplier_name,
                        pending_bills[i].amount,
                    "<button class='btn btn-success btn-xs add' data='"+ pending_bills[i].id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>"
                    ]).draw();

                }
            }

            // add bills to receiving table
            $("#pending_table tbody").on('click','.add',function(){

                var row = $(this).parents('tr');
                var bill_id = $(this).attr('data');
            
                // validation
                if(recieving_bill.length==20){
                    toastr.error('Cannot add more than 20 records');
                    return this;
                }

                if(recieving_bill.includes(bill_id)){
                    toastr.error('Cannot add duplicates');
                    return this;

                }else{

                    recieving_bill.push(bill_id);

                    var module_name=(row.find('td:nth-child(1)').text());
                    var date=(row.find('td:nth-child(2)').text());
                    var project=(row.find('td:nth-child(3)').text());
                    var supplier=(row.find('td:nth-child(4)').text());
                    var amount=(row.find('td:nth-child(5)').text());

                    receiving_table.row.add([module_name,date,project,supplier,amount,"<button class='btn btn-xs btn-danger remove' data='"+bill_id+"'><i class='fas fa-arrow-left'></i></button>"
                    ]).draw();
                    pending_table.row(row).remove().draw();

                }


            });

            // remove bills to receiving table
            $("#receiving_table tbody").on('click','.remove',function(){

                var row = $(this).parents('tr');

                var bill_id = $(this).attr('data');

                var module_name=(row.find('td:nth-child(1)').text());
                var date=(row.find('td:nth-child(2)').text());
                var project=(row.find('td:nth-child(3)').text());
                var supplier=(row.find('td:nth-child(4)').text());
                var amount=(row.find('td:nth-child(5)').text());


                const index = recieving_bill.indexOf(bill_id);

                if (index > -1) {
                    recieving_bill.splice(index, 1); 

                    pending_table.row.add([module_name, date, project, supplier, amount, "<button class='btn btn-success btn-xs add' data='"+bill_id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>"
                    ]).draw();
           
                    receiving_table.row(row).remove().draw();

                }

            });

            $(document).on('click','.bill_receive',function(){

                if( recieving_bill.length > 0 ){

                    $.ajax({
                        'type': 'ajax',
                        'dataType': 'json',
                        'method': 'post',
                        'async': false,
                        'data': {bill_id:recieving_bill},
                        'url': 'payment_bill/bulk_bill_receive',
                        success: function(data){

                            if(data.db_error){
                                db_error(data.db_error);
                            }

                            if(data.db_success){
                                db_success(data.db_success);
                                setTimeout(function(){
                                    $("#modal").modal('hide');
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });

                }

            });

        });

    });

    function show_session_bills(){

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'async': false,
            'url': 'get_session',
            success: function(data){

            if(data.bill_session == 'pending_bill'){
                show_pending_bills();
            }else if(data.bill_session == 'received_bill'){
                show_received_bills();
            }

            }
        });

    }

    function show_pending_bills(){

        $("#option1").addClass('btn-active');
        $("#option2").removeClass('btn-active');

        $(".bulk_receive").css("display", "block");

        var project_id = $("#project_id_s").val();
        var supplier_id = $("#supplier_id_s").val();
        var table_search = $("#table_search").val();

        $('#dataTable').DataTable().clear();
        $('#dataTable').DataTable().destroy();

        $("#dataTable").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            'searching': false,
            'ajax': {
                        'method': 'get',
                        'url': 'payment_bill/pending_payment_bills_datatable'
            },
            'columns': [
                {data: 'module'},
                {data: 'project_name'},
                {data: 'supplier_name'},
                {data: 'invoice_date'},
                {data: 'bill_refference'},
                {data: 'amount',
                    render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },
                {
                data: null,
                render: function(d){

                    var html = "";

                    html+="<button class='btn btn-success btn-xs receive' data='"+d.id+"' title='Recieve Bill'>Recieve</button>";
                    
                    return html;
                }
                }
            ]
        })


    }

    function show_received_bills(){

        $("#option2").addClass('btn-active');
        $("#option1").removeClass('btn-active');

        $(".bulk_receive").css("display", "none");

        var project_id = $("#project_id_s").val();
        var supplier_id = $("#supplier_id_s").val();
        var table_search = $("#table_search").val();

        $('#dataTable').DataTable().clear();
        $('#dataTable').DataTable().destroy();

        $("#dataTable").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            'searching': false,
            'ajax': {
                        'method': 'get',
                        'url': 'payment_bill/received_payment_bills_datatable'
            },
            'columns': [
                {data: 'module'},
                {data: 'project_name'},
                {data: 'supplier_name'},
                {data: 'invoice_date'},
                {data: 'bill_refference'},
                {data: 'amount',
                    render: $.fn.dataTable.render.number( ',', '.', 2, '' ) },
                {
                data: null,
                render: function(d){

                    var html = "";

                    // html+="<button class='btn btn-success btn-xs receive' data='"+d.id+"' title='Recieved'>Recieved</button>";
                    
                    return html;
                }
                }
            ]
        })


    }

    function get_pending_bills(){

        var result;

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'payment_bill/pending_payment_bills',
            'async': false,
            success: function(data){

                result = data;
                
            }

        });

        return result;
    }

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