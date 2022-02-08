@extends('layouts.app')

@section('content')
<style>

    .btn-active{
        background-color: #ddd;
    }

</style>

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
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        show_pending_bills();
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
                {data: 'amount'},
                {
                data: null,
                render: function(d){

                    var html = "";

                    html+="<button class='btn btn-warning btn-xs edit' data='"+d.id+"' title='Edit Bill'><i class='fas fa-edit'></i></button>";
                    html+="<button class='btn btn-danger btn-xs delete' data='"+d.id+"' title='Delete Bill'><i class='fas fa-trash'></i></button>";
                    html+="<button class='btn btn-primary btn-xs document' data='"+d.id+"' title='Add Documents'><i class='fas fa-scroll'></i></button>";
                    html+="<button class='btn btn-success btn-xs submit_ho' data='"+d.id+"' title='Submit bill to Head Office'>Submit</button>";

                    return html;
                }
                }
            ]
        })


    }

</script>
@endsection