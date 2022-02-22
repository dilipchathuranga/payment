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
<!-- pending receive modal -->
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
                                <div class="row">
                                    <div class="col-md-6">
                                            &nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm float-right">
                                        <select name="module_s1" id="module_s1" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                            <option value="">-- search by module --</option>
                                            <option value="Security Section">Security Section</option>
                                            <option value="Sub Contract Section">Sub Contract Section</option>
                                            <option value="Supply Bill Section">Supply Bill Section</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            &nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm float-right">
                                        <select name="project_id_s1" id="project_id_s1" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                                        <div class="input-group input-group-sm float-right">
                                        <select name="supplier_id_s1" id="supplier_id_s1" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                                        <div class="input-group input-group-sm float-right">
                                            <input type="text" class="form-control datepicker float-right" name="invoice_month_s1" id="invoice_month_s1"  placeholder="Search by Invoice Date" value="" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-hover" id="pending_table" >
                                    <thead>                  
                                        <tr>
                                            <th style="font-size: 12px;">Module</th>
                                            <th style="font-size: 12px;">Invoice Date</th>
                                            <th style="font-size: 12px;">Project</th>
                                            <th style="font-size: 12px;">Supplier</th>
                                            <th style="font-size: 12px;">Amount</th>
                                            <th style="font-size: 12px;">Action</th>
                                            <th style="display:none;"> Project ID</th>
                                            <th style="display:none;">Supplier ID</th>
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
                                            <th style="display:none;"> Project ID</th>
                                            <th style="display:none;">Supplier ID</th>
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
<!-- new schdule modal -->
<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Received Bills</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                            &nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm float-right">
                                        <select name="module_s2" id="module_s2" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                            <option value="">-- search by module --</option>
                                            <option value="Security Section">Security Section</option>
                                            <option value="Sub Contract Section">Sub Contract Section</option>
                                            <option value="Supply Bill Section">Supply Bill Section</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            &nbsp;
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm float-right">
                                        <select name="project_id_s2" id="project_id_s2" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                                        <div class="input-group input-group-sm float-right">
                                        <select name="supplier_id_s2" id="supplier_id_s2" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                                        <div class="input-group input-group-sm float-right">
                                            <input type="text" class="form-control datepicker float-right" name="invoice_month_s2" id="invoice_month_s2"  placeholder="Search by Invoice Date" value="" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-hover" id="received_table" >
                                    <thead>                  
                                        <tr>
                                            <th style="font-size: 12px;">Module</th>
                                            <th style="font-size: 12px;">Invoice Date</th>
                                            <th style="font-size: 12px;">Project</th>
                                            <th style="font-size: 12px;">Supplier</th>
                                            <th style="font-size: 12px;">Amount</th>
                                            <th style="font-size: 12px;">Action</th>
                                            <th style="display:none;"> Project ID</th>
                                            <th style="display:none;">Supplier ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">New Schedule</h3>
                            </div>
                            <div class="card-body">
                                <form>
                                    <input type="hidden" id="hid" name="hid">
                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        &nbsp;
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="schedule_date" name="schedule_date" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                        <label for="refference_no">Refference No</label>
                                        <input type="text" class="form-control" id="refference_no" name="refference_no" placeholder="Enter Refference No" required>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <table class="table table-hover" id="schedule_table" >
                                    <thead>                  
                                        <tr>
                                            <th style="font-size: 12px;">Module</th>
                                            <th style="font-size: 12px;">Invoice Date</th>
                                            <th style="font-size: 12px;">Project</th>
                                            <th style="font-size: 12px;">Supplier</th>
                                            <th style="font-size: 12px;">Amount</th>
                                            <th style="font-size: 12px;">Action</th>
                                            <th style="display:none;"> Project ID</th>
                                            <th style="display:none;">Supplier ID</th>
                                            <th style="display:none;">Account ID</th>
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
            <button type="button" class="btn btn-success add_schedule" id="submit">Create Schedule</button>
          </div>
      </div>
    </div>
</div>

<!-- supplier_account modal -->
<div class="modal fade " id="modal2" >
    <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content" >
        <div class="modal-header">
            <h5 class="modal-title">Select Account</h5>
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
                                <th style="font-size: 12px;">Bank</th>
                                <th style="font-size: 12px;">Branch</th>
                                <th style="font-size: 12px;">Account No</th>
                                <th style="font-size: 12px;">Account Name</th>
                                <th style="font-size: 12px;">Action</th>
                                <th style="display:none;">Supplier ID</th>
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
                      <select name="module_s" id="module_s" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                          <option value="">-- search by module --</option>
                          <option value="Security Section">Security Section</option>
                          <option value="Sub Contract Section">Sub Contract Section</option>
                          <option value="Supply Bill Section">Supply Bill Section</option>
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
                            <input type="text" class="form-control datepicker float-right" name="invoice_month_s" id="invoice_month_s"  placeholder="Search by Invoice Date" value="" />
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-9">
                        &nbsp;
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-sm float-right" >
                            <button class="btn btn-primary btn-block bulk_receive" style="display: none;"><i class="fas fa-download"></i> Bulk Bill Recieve</button>
                        </div>
                        <div class="input-group input-group-sm float-right" >
                            <button class="btn btn-success btn-block new_schedule" style="display: none;"><i class="fas fa-plus"></i> Create New Schedule</button>
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

        $("#invoice_month_s, #invoice_month_s1, #invoice_month_s2").datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months"
        });

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

        $(document).on('change', '#project_id_s', function(){
            show_session_bills();
        })

        $(document).on("change","#supplier_id_s", function(){
            show_session_bills();
        });

        $(document).on('change', '#module_s', function(){
            show_session_bills();
        });

        $(document).on('change', '#invoice_month_s', function(){
            show_session_bills();
        });

        get_supplier_search();
        get_project_search();

        $(".bulk_receive").click(function(){ // bulk receive modal

            $("#modal").modal('show');

            // receiving id array
            var recieving_bill = [];

            // get pending bills
            var pending_bills = get_pending_bills();

            // bill pending table 
            $('#pending_table').DataTable().clear();
            $('#pending_table').DataTable().destroy();

            var pending_table = $("#pending_table").DataTable({
                "paging": false,
                "pageLength": 20,
                fixedColumns: true

            });

            pending_table.columns(6).visible(false);
            pending_table.columns(7).visible(false);

            // bill receiving table
            $('#receiving_table').DataTable().clear();
            $('#receiving_table').DataTable().destroy();

            var receiving_table=$("#receiving_table").DataTable({
                "paging": false,
                "pageLength": 20,
                fixedColumns: true
                
            });

            receiving_table.columns(6).visible(false);
            receiving_table.columns(7).visible(false);

            //add pending table data
            if(pending_bills.length > 0){
                for(var i=0; i < pending_bills.length; i++){

                    pending_table.row.add([pending_bills[i].module,
                        pending_bills[i].invoice_date,
                        pending_bills[i].project_name,
                        pending_bills[i].supplier_name,
                        pending_bills[i].amount,
                    "<button class='btn btn-success btn-xs add' data='"+ pending_bills[i].id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>",
                        pending_bills[i].project_id,
                        pending_bills[i].supplier_id
                    ]).draw();

                }

            }

            //pending table search
            $(document).on('change', '#project_id_s1', function(){
                var value = $(this).val();
                if(value!= ""){
                    pending_table.columns(6).search(value).draw();
                }else{
                    pending_table.columns(6).search("").draw();
                }
                
            });

            $(document).on("change","#supplier_id_s1", function(){
                var value = $(this).val();
                if(value!= ""){
                    pending_table.columns(7).search(value).draw();
                }else{
                    pending_table.columns(7).search("").draw();
                }
            });

            $(document).on('change', '#module_s1', function(){
                var value = $(this).val();
                if(value!= ""){
                    pending_table.columns(0).search(value).draw();
                }else{
                    pending_table.columns(0).search("").draw();
                }
            });

            $(document).on('change', '#invoice_month_s1', function(){
                var value = $(this).val();
                if(value!= ""){
                    pending_table.columns(1).search(value).draw();
                }else{
                    pending_table.columns(1).search("").draw();
                }
            });


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
                    var project_id=(row.find('td:nth-child(6)').text());
                    var supplier_id=(row.find('td:nth-child(7)').text());
                    receiving_table.row.add([module_name,date,project,supplier,amount,"<button class='btn btn-xs btn-danger remove' data='"+bill_id+"'><i class='fas fa-arrow-left'></i></button>",project_id,supplier_id
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
                var project_id=(row.find('td:nth-child(6)').text());
                var supplier_id=(row.find('td:nth-child(7)').text());

                const index = recieving_bill.indexOf(bill_id);

                if (index > -1) {
                    recieving_bill.splice(index, 1); 

                    pending_table.row.add([module_name, date, project, supplier, amount, "<button class='btn btn-success btn-xs add' data='"+bill_id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>",project_id,supplier_id
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
                                toastr.error(data.db_error);
                            }

                            if(data.db_success){
                                toastr.success(data.db_success);
                                setTimeout(function(){
                                    $("#modal").modal('hide');
                                    location.reload();
                                }, 1000);
                            }
                        }
                    });

                }else{
                    toastr.error('Add Bills to Receive First');
                }

            });

        });

        $(document).on('click', '.receive', function(){

            var id = $(this).attr('data');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reeceive Bill!'
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        'type': 'ajax',
                        'dataType': 'json',
                        'method': 'get',
                        'async': false,
                        'url': '/payment_bill/bill_receive/'+id,
                        success: function(data){

                            if(data.db_error){
                                toastr.error(data.db_error);
                            }

                            if(data.db_success){
                                toastr.success(data.db_success);
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            }
                        }
                    });

                }
            });

        });

        $(".new_schedule").click(function(){ // new schedule modal

            $("#modal1").modal('show');

            // receiving id array
            var schedule_bill = [];

            // get received bills
            var received_bills = get_received_bills();

            // bill received table 
            $('#received_table').DataTable().clear();
            $('#received_table').DataTable().destroy();

            var received_table = $("#received_table").DataTable({
                "paging": false,
                "pageLength": 20,
                fixedColumns: true

            });

            received_table.columns(6).visible(false);
            received_table.columns(7).visible(false);

            // bill schedule table
            $('#schedule_table').DataTable().clear();
            $('#schedule_table').DataTable().destroy();

            var schedule_table=$("#schedule_table").DataTable({
                "paging": false,
                "searching": false,
                "pageLength": 20,
                fixedColumns: true
                
            });

            schedule_table.columns(6).visible(false);
            schedule_table.columns(7).visible(false);
            schedule_table.columns(8).visible(false);

            //add received bills table data
            if(received_bills.length > 0){
                for(var i=0; i < received_bills.length; i++){

                    received_table.row.add([received_bills[i].module,
                        received_bills[i].invoice_date,
                        received_bills[i].project_name,
                        received_bills[i].supplier_name,
                        received_bills[i].amount,
                    "<button class='btn btn-success btn-xs add' data='"+ received_bills[i].id+"'  data-supplier_id='"+received_bills[i].supplier_id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>",
                        received_bills[i].project_id,
                        received_bills[i].supplier_id
                    ]).draw();

                }

            }
            
            // add bills to receiving table
            $("#received_table tbody").on('click','.add',function(){

                $("#modal2").modal('show');
                var bill_id = $(this).attr('data');
                var supplier_id = $(this).attr('data-supplier_id'); 
                var project_id = $(this).attr('data-project_id'); 
                var row = $(this).parents('tr');

                $.ajax({
                    'type': 'ajax',
                    'dataType': 'json',
                    'method': 'get',
                    'url': '/get_accounts_by_supplier/'+supplier_id,
                    'async': false,
                    success: function(data){

                        // bill accounts table 
                        $('#account_table').DataTable().clear();
                        $('#account_table').DataTable().destroy();

                        var account_table = $("#account_table").DataTable({
                            "paging": false,
                            "pageLength": 20,
                            fixedColumns: true

                        });

                        account_table.columns(5).visible(false);

                        for(var i=0; i < data.length; i++){

                            account_table.row.add([data[i].bank_name,
                            data[i].branch_name,
                            data[i].account_no,
                            data[i].account_name,
                            "<button class='btn btn-success btn-xs add_account' title='Select Account' data='"+data[i].id+"' ><i class='fas fa-arrow-right'></i></button>",
                            data[i].supplier_id
                            ]).draw();


                        }

                        $(document).on('click','.add_account',function(){

                            var account_id = $(this).attr('data');

                            // validation
                            if(schedule_bill.length==20){
                                toastr.error('Cannot add more than 20 records');
                                return this;
                            }

                            if(schedule_bill.includes(bill_id)){
                                toastr.error('Cannot add duplicates');
                                return this;

                            }else{

                                schedule_bill.push(bill_id);

                                var module_name=(row.find('td:nth-child(1)').text());
                                var date=(row.find('td:nth-child(2)').text());
                                var project=(row.find('td:nth-child(3)').text());
                                var supplier=(row.find('td:nth-child(4)').text());
                                var amount=(row.find('td:nth-child(5)').text());

                                schedule_table.row.add([
                                    module_name,
                                    date,
                                    project,
                                    supplier,
                                    amount,
                                    "<button class='btn btn-xs btn-danger remove' data='"+bill_id+"' data-supplier_id='"+supplier_id+"' data-project_id='"+project_id+"'><i class='fas fa-arrow-left'></i></button>",
                                    project_id,
                                    supplier_id,
                                    account_id
                                ]).draw();

                                received_table.row(row).remove().draw();

                                $("#modal2").modal('hide');

                            }


                        });

                    }

                });

            });

                // remove bills to receiving table
            $("#schedule_table tbody").on('click','.remove',function(){

                var row = $(this).parents('tr');

                var bill_id = $(this).attr('data');

                var module_name=(row.find('td:nth-child(1)').text());
                var date=(row.find('td:nth-child(2)').text());
                var project=(row.find('td:nth-child(3)').text());
                var supplier=(row.find('td:nth-child(4)').text());
                var amount=(row.find('td:nth-child(5)').text());
                var project_id= $(this).attr('data-project_id');
                var supplier_id= $(this).attr('data-supplier_id');


                const index = schedule_bill.indexOf(bill_id);

                if (index > -1) {
                    schedule_bill.splice(index, 1); 

                    received_table.row.add([module_name,
                                            date,
                                            project, 
                                            supplier, 
                                            amount, 
                                            "<button class='btn btn-success btn-xs add' data='"+bill_id+"' data-supplier_id='"+supplier_id+"' data-project_id='"+project_id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>" ,
                                            project_id,
                                            supplier_id
                                        ]).draw();

                    schedule_table.row(row).remove().draw();

                }
            

            });

            $(document).on('click','.add_schedule',function(){

            if( schedule_bill.length > 0 ){

                var date = $("#schedule_date").val();
                var refference_no = $("#refference_no").val();

                //validation
                if(date==""){
                    toastr.error("Date Feild is Required");
                    return this;
                }

                if(refference_no==""){
                    toastr.error("Refference No Feild is Required");
                    return this;
                }

                $.ajax({
                    'type': 'ajax',
                    'dataType': 'json',
                    'method': 'post',
                    'async': false,
                    'data': {bill_id:schedule_bill, date:date, refference_no:refference_no},
                    'url': 'payment_bill/create_schedule',
                    success: function(data){

                        if(data.db_error){
                            toastr.error(data.db_error);
                        }

                        if(data.db_success){
                            toastr.success(data.db_success);
                            setTimeout(function(){
                                $("#modal1").modal('hide');
                                location.reload();
                            }, 1000);
                        }
                    }
                });

            }else{
                toastr.error('Add Bills First');
            }

            });

            
            //received table search
            $(document).on('change', '#project_id_s2 ', function(){
                var value = $(this).val();
                if(value!= ""){
                    received_table.columns(6).search(value).draw();
                }else{
                    received_table.columns(6).search("").draw();
                }
                
            });

            $(document).on("change","#supplier_id_s2", function(){
                var value = $(this).val();
                if(value!= ""){
                    received_table.columns(7).search(value).draw();
                }else{
                    received_table.columns(7).search("").draw();
                }
            });

            $(document).on('change', '#module_s2', function(){
                var value = $(this).val();
                if(value!= ""){
                    received_table.columns(0).search(value).draw();
                }else{
                    received_table.columns(0).search("").draw();
                }
            });

            $(document).on('change', '#invoice_month_s2', function(){
                var value = $(this).val();
                if(value!= ""){
                    received_table.columns(1).search(value).draw();
                }else{
                    received_table.columns(1).search("").draw();
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
        $(".new_schedule").css("display", "none");

        var project_id = $("#project_id_s").val();
        var supplier_id = $("#supplier_id_s").val();
        var module = $("#module_s").val();
        var invoice_month = $("#invoice_month_s").val();

        $('#dataTable').DataTable().clear();
        $('#dataTable').DataTable().destroy();

        $("#dataTable").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            'searching': false,
            'ajax': {
                        'method': 'post',
                        'data': {project_id:project_id, supplier_id:supplier_id, module:module, invoice_month:invoice_month},
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
        $(".new_schedule").css("display", "block");

        var project_id = $("#project_id_s").val();
        var supplier_id = $("#supplier_id_s").val();
        var module = $("#module_s").val();
        var invoice_month = $("#invoice_month_s").val();

        $('#dataTable').DataTable().clear();
        $('#dataTable').DataTable().destroy();

        $("#dataTable").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            'searching': false,
            'ajax': {
                        'method': 'post',
                        'data': {project_id:project_id, supplier_id:supplier_id, module:module, invoice_month:invoice_month},
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

    function get_received_bills(){

        var result;

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'payment_bill/received_payment_bills',
            'async': false,
            success: function(data){

                result = data;
                
            }

        });

        return result;      
    }

    function get_supplier_search(){

        var result;

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'http://fin.maga.engineering/api/get_suppliers?api_token=MAGA_AUHT_00001',
            'async': false,
            success: function(data){

                var html = "";

                html+="<option value=''>-- search by supplier --</option>";

                    for(var i =0; i < data.length; i++){
                        html+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
                    }

                // supplier search 
                $("#supplier_id_s").html(html);
                $("#supplier_id_s").selectpicker("refresh");
                $("#supplier_id_s").val("");
                $("#supplier_id_s").selectpicker("refresh");

                // supplier search 1
                $("#supplier_id_s1").html(html);
                $("#supplier_id_s1").selectpicker("refresh");
                $("#supplier_id_s1").val("");
                $("#supplier_id_s1").selectpicker("refresh");

                // supplier search 2
                $("#supplier_id_s2").html(html);
                $("#supplier_id_s2").selectpicker("refresh");
                $("#supplier_id_s2").val("");
                $("#supplier_id_s2").selectpicker("refresh");

                    
            }

        });

    }

    function get_project_search(){

        var result;

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'http://fin.maga.engineering/api/get_projects?api_token=MAGA_AUHT_00001',
            'async': false,
            success: function(data){

                var html = "";

                html+="<option value=''>-- search by project --</option>";

                    for(var i =0; i < data.length; i++){
                        html+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
                    }

                $("#project_id_s").html(html);
                $("#project_id_s").selectpicker("refresh");
                $("#project_id_s").val("");
                $("#project_id_s").selectpicker("refresh");

                $("#project_id_s1").html(html);
                $("#project_id_s1").selectpicker("refresh");
                $("#project_id_s1").val("");
                $("#project_id_s1").selectpicker("refresh");

                $("#project_id_s2").html(html);
                $("#project_id_s2").selectpicker("refresh");
                $("#project_id_s2").val("");
                $("#project_id_s2").selectpicker("refresh");
                    
            }

        });

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