@extends('layouts.app')

@section('content')

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
                                <th style="width:20%">Refference No</th>
                                <th style="width:20%">Action</th>
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
