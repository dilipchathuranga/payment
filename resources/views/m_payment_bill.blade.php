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
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success submit" id="submit">Save changes</button>
          </div> -->
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
<script>
    $(document).ready(function(){

        var recieving_bill = [];
        var pending_bill = [];

        show_pending_bills();

        $(".bulk_receive").click(function(){

            $("#modal").modal('show');

            var pending_table;
            var receiving_table;

            // bill pending table 
            $('#pending_table').DataTable().clear();
            $('#pending_table').DataTable().destroy();

            pending_table = $("#pending_table").DataTable({
                'processing': true,
                'serverSide': true,
                "bLengthChange": false,
                "autoWidth": false,
                'searching': false,
                'ajax': {
                            'method': 'post',
                            'url': 'http://demofin.maga.engineering/api/pending_payment_bills?api_token=MAGA_AUHT_00001'
                },
                'columns': [
                    {data: 'module'},
                    {data: 'invoice_date'},
                    {data: 'project_name'},
                    {data: 'supplier_name'},
                    {data: 'amount',
                        render: $.fn.dataTable.render.number( ',', '.', 2, '' )},
                    {
                    data: null,
                    render: function(d){

                        var html = "";

                        html+="<button class='btn btn-success btn-xs receive' data='"+d.id+"' title='Recieve Bill'><i class='fas fa-arrow-right'></i></button>";
                        
                        return html;
                    }
                    }
                ],

                fixedColumns: true,
                "fnPreDrawCallback": function(oSettings) {
                    /* reset pending_bill before each draw*/
                    pending_bill = [];
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    /* push this row of data to pending_bill array*/
                    pending_bill.push(aData);

                },
                "fnDrawCallback": function(oSettings) {
                    /* can now access sorted data array*/
                    // console.log(pending_bill)
                }

            });

            // bill receiving table
            $('#receiving_table').DataTable().clear();
            $('#receiving_table').DataTable().destroy();

            receiving_table=$("#receiving_table").DataTable({
                "paging": false,
                "searching": false,
                "pageLength": 20,
                fixedColumns: true,
                "fnPreDrawCallback": function(oSettings) {
                    /* reset pending_bill before each draw*/
                    recieving_bill = [];

                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    /* push this row of data to pending_bill array*/
                    recieving_bill.push(aData);


                },
                "fnDrawCallback": function(oSettings) {
                    /* can now access sorted data array*/
                    // console.log(recieving_bill)
                }
            });



        });

    });

    function show_pending_bills(){

        $("#option1").addClass('btn-active');
        $("#option2").removeClass('btn-active');

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
                        'method': 'post',
                        'data': {project_id:project_id, supplier_id:supplier_id, table_search:table_search},
                        'url': 'http://demofin.maga.engineering/api/pending_payment_bills?api_token=MAGA_AUHT_00001'
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

</script>
@endsection