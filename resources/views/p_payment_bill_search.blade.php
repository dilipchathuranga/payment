@extends('layouts.app')

@section('content')
<style>
    .table#tbl_paymentsearch  {
        table-layout: fixed;
         width: 100% !important;
    }

    .table#tbl_paymentsearch td {
        font-size: 10px;
    }
</style>

<!-- supplier_account modal -->
<div class="modal fade " id="modal1" >
    <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title">Transaction Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-outline card-danger">
                    <div class="card-body">
                        <table class="table table-hover" id="tranfer_log" >
                            <thead>
                                <tr>
                                    <th style="width:30%">Date</th>
                                    <th style="width:40%">Status</th>
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
            <h1 class="m-0 text-dark">Payment Bill Search</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Payment</a></li>
              <li class="breadcrumb-item active">Payment Search</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                                &nbsp;
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm float-right">
                            <select name="module" id="module" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                <option value="">-- search by module --</option>
                                <option value="Security Section">Security Section</option>
                                <option value="Sub Contract Section">Sub Contract Section</option>
                                <option value="Supply Bill Section">Supply Bill Section</option>
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
                            <select name="master_no" id="master_no" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                <option value="">-- search by project --</option>

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
                            <select name="bp_no" id="bp_no" class="form-control selectpicker"  required data-live-search="true" data-size="5">
                                <option value="">-- search by supplier --</option>

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
                                <input type="text" class="form-control datepicker float-right" name="invoice_month" id="invoice_month"  placeholder="Search by Invoice Date" value="" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered" id="tbl_paymentsearch">
                        <thead>
                            <tr>
                                <th style="width:10%">Module</th>
                                <th style="width:10%">Project</th>
                                <th style="width:10%">Supplier</th>
                                <th style="width:10%">Invoice Date</th>
                                <th style="width:20%">Bill Refference</th>
                                <th style="width:10%">Amount</th>
                                <th style="width:10%">Paid Date</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
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
    $(document).ready(function(){
        var paymentsearch;
        // menu active
            $(".payment_search_route").addClass('active');

            show_payment_bill();
            get_supplier_search();
            get_project_search();

            //csrf token error
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#invoice_month").datepicker( {
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months"
            });
    });

        //Data Table show
        function show_payment_bill(){

                $('#tbl_paymentsearch').DataTable().clear();
                $('#tbl_paymentsearch').DataTable().destroy();

                paymentsearch = $("#tbl_paymentsearch").DataTable({
                    'processing': true,
                    'serverSide': true,
                    "bLengthChange": false,
                    'ajax': {
                                'method': 'get',
                                'url': 'payment_search/create'
                    },
                    'columns': [
                        {data: 'module'},
                        {data: 'project_name'},
                        {data: 'supplier_name'},
                        {data: 'invoice_date'},
                        {data: 'bill_refference'},
                        {data: 'amount'},
                        {data: 'invoice_date'},
                        {
                            data: null,

                            render:function(d){

                                var html = "";
                                if(d.status=='0'){
                                    html = "<span style='padding:5px' class='badge badge-warning'>Pending</span>";
                                }
                                if(d.status=='1'){
                                    html = "<span style='padding:5px' class='badge badge-secondary'>Received</span>";
                                }
                                if(d.status=='2'){
                                    html = "<span style='padding:5px' class='badge badge-info'>Scheduled</span>";
                                }
                                if(d.status=='3'){
                                    html = "<span style='padding:5px' class='badge badge-success'>Paid</span>";
                                }

                                return html;
                            }
                        },
                        {
                            data: null,
                            render: function(d){

                                var html = "";

                                html+="<button class='btn btn-warning btn-sm tranfer_log' data='"+d.id+"' title='Tranfer Log'><i class='fas fa-file-invoice'></i></button>";

                                return html;
                            }
                        }
                    ]
                });

             //bill search table search
            $(document).on('change', '#master_no ', function(){
                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(6).search(value).draw();
                }else{
                    paymentsearch.columns(6).search("").draw();
                }

            });

            $(document).on("change","#bp_no", function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(2).search(value).draw();
                }else{
                    paymentsearch.columns(2).search("").draw();
                }
            });

            $(document).on('change', '#module', function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(0).search(value).draw();
                }else{
                    paymentsearch.columns(0).search("").draw();
                }
            });

            $(document).on('change', '#invoice_month', function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(3).search(value).draw();
                }else{
                    paymentsearch.columns(3).search("").draw();
                }
            });

        }

        $(document).on('click', '.tranfer_log', function(){

            var id = $(this).attr('data');

            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'get',
                'url': 'payment_search/tranfer_log/'+id,
                'async': false,
                success: function(data){
                    $("#modal1").modal('show');

                    $('#tranfer_log').DataTable().clear();
                    $('#tranfer_log').DataTable().destroy();

                    $("#tranfer_log").DataTable({
                        'processing': true,
                        'serverSide': true,
                        "autoWidth": false,
                        "bLengthChange": false,
                        "aaSorting": [[1,'asc']],

                            'ajax': {
                                'method': 'get',
                                'url': 'payment_search/tranfer_log/'+id,
                            },

                            'columns': [
                                {data: 'date'},
                                {
                                    data: null,

                                    render:function(d){

                                        var html = "";
                                        if(d.status=='0'){
                                            html = "Pending";
                                        }
                                        if(d.status=='1'){
                                            html = "Received";
                                        }
                                        if(d.status=='2'){
                                            html = "Scheduled";
                                        }
                                        if(d.status=='3'){
                                            html = "Paid";
                                        }

                                        return html;
                                    }
                                },
                            ]
                    });
                },
            });
        });


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
                        $("#bp_no").html(html);
                        $("#bp_no").selectpicker("refresh");
                        $("#bp_no").val("");
                        $("#bp_no").selectpicker("refresh");
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

                            $("#master_no").html(html);
                            $("#master_no").selectpicker("refresh");
                            $("#master_no").val("");
                            $("#master_no").selectpicker("refresh");

                    }

                });

        }


</script>
@endsection
