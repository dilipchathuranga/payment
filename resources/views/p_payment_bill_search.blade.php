@extends('layouts.app')

@section('content')
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
                            <select name="maser_no_s2" id="maser_no_s2" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                            <select name="bp_no_s2" id="bp_no_s2" class="form-control selectpicker"  required data-live-search="true" data-size="5">
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
                    <table class="table table-bordered" id="tbl_paymentsearch">
                        <thead>
                            <tr>
                                <th style="width:10%">Module</th>
                                <th style="width:10%">Project</th>
                                <th style="width:10%">Supplier</th>
                                <th style="width:10%">Invoice Date</th>
                                <th style="width:20%">Bill Refference</th>
                                <th style="width:10%">Amount</th>
                                <th style="width:10%">Pay Date</th>
                                <th style="width:20%">Status</th>
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
        var paymentsearch
        // menu active
            $(".paymentsearch_route").addClass('active');

            show_payment_bill();
            get_supplier_search();
            get_project_search();



        //csrf token error
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#invoice_month_s2").datepicker( {
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
                                'url': 'paymentsearch/create'
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
                                    html+= "Pending";
                                }
                                if(d.status=='1'){
                                    html+= "Recived";
                                }
                                if(d.status=='2'){
                                    html+= "Sheduled";
                                }
                                if(d.status=='3'){
                                    html+= "Paied";
                                }

                                return html;
                            }
                        },
                    ]
                });

             //bill search table search
            $(document).on('change', '#maser_no_s2 ', function(){
                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(6).search(value).draw();
                }else{
                    paymentsearch.columns(6).search("").draw();
                }

            });

            $(document).on("change","#bp_no_s2", function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(2).search(value).draw();
                }else{
                    paymentsearch.columns(2).search("").draw();
                }
            });

            $(document).on('change', '#module_s2', function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(0).search(value).draw();
                }else{
                    paymentsearch.columns(0).search("").draw();
                }
            });

            $(document).on('change', '#invoice_month_s2', function(){

                var value = $(this).val();
                if(value!= ""){
                    paymentsearch.columns(3).search(value).draw();
                }else{
                    paymentsearch.columns(3).search("").draw();
                }
            });

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

                    // supplier search 2
                    $("#bp_no_s2").html(html);
                    $("#bp_no_s2").selectpicker("refresh");
                    $("#bp_no_s2").val("");
                    $("#bp_no_s2").selectpicker("refresh");


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


                        $("#maser_no_s2").html(html);
                        $("#maser_no_s2").selectpicker("refresh");
                        $("#maser_no_s2").val("");
                        $("#maser_no_s2").selectpicker("refresh");

                    }

                });

        }


</script>
@endsection
