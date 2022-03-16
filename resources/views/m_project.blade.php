@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="m-0 text-dark">Project</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item active">Project</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="tbl_supplier">
                        <thead>
                            <tr>
                                <th style="width:10%">Master No</th>
                                <th style="width:20%">Name</th>
                                <th style="width:20%">Address</th>
                                <th style="width:10%">Telephone Number</th>
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
        $(".project_route").addClass('active');

        show_project();

    //csrf token error
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    //Data Table show
        function show_project(){
                $('#tbl_supplier').DataTable().clear();
                $('#tbl_supplier').DataTable().destroy();

                $("#tbl_supplier").DataTable({
                    'processing': true,
                    'serverSide': true,
                    "bLengthChange": false,
                    'ajax': {
                                'method': 'get',
                                'url': 'project/create'
                    },
                    'columns': [
                        {data: 'master_no'},
                        {data: 'name'},
                        {data: 'address'},
                        {data: 'tele_no'},
                    ]
                });
        }
</script>
@endsection
