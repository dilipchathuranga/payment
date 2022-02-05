@extends('layouts.app')

@section('content')
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Branch</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <form>
              <input type="hidden" id="hid" name="hid">
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="levy">Bank Name</label>
                    <select name="bank_id" id="bank_id" class="form-control selectpicker" required data-live-search="true" data-size="5">
                        <option value="">-- select branch --</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                  <label for="code">Branch Code</label>
                  <input type="text" class="form-control" id="code" name="code" placeholder="Enter Branch Code" required>
                  </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="rate">Branch Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Branch Name" required>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success submit" id="submit">Save changes</button>
          </div>
      </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="m-0 text-dark">Branch</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item"><a href="#">Bank</a></li>
              <li class="breadcrumb-item active">Branch</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addNew"><i class="fa fa-plus"></i> Add New Branch</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tblbranch">
                        <thead>
                        <tr>
                            <th style="width:20%">Bank Name</th>
                            <th style="width:20%">Branch Code</th>
                            <th style="width:30%">Branch Name</th>
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
    $(".bank_treeview").addClass('menu-open');
    $(".branch_route").addClass('active');

    //csrf token error
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    show_types();

    $(".form-control").blur(function(){
        $("#submit").css("display","block");
    });

    $(".addNew").click(function(){
        empty_form();
        $("#modal").modal('show');
        $(".modal-title").html('Save Branch');
        $("#submit").html('Save Branch');
        $("#submit").click(function(){
            $("#submit").css("display","none");
            var hid =$("#hid").val();
            //save bank
            if(hid == ""){
                var bank_id =$("#bank_id").val();
                var name =$("#name").val();
                var code =$("#code").val();

                $.ajax({
                    'type': 'ajax',
                    'dataType': 'json',
                    'method': 'post',
                    'data' : {bank_id:bank_id,name:name,code:code },
                    'url' : 'branch',
                    'async': false,
                    success:function(data){
                        if(data.validation_error){
                        validation_error(data.validation_error);//if has validation error call this function
                        }

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

                    },
                    error: function(jqXHR, exception) {
                        db_error(jqXHR.responseText);
                    }
                });
            };
        });
    });


    $(document).on("click", ".edit", function(){
        var id = $(this).attr('data');

        empty_form();
        $("#hid").val(id);
        $("#modal").modal('show');
        $(".modal-title").html('Edit Branch');
        $("#submit").html('Update Bank');
            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'get',
                'url': 'branch/'+id,
                'async': false,
                success: function(data){
                $("#hid").val(data.id);
                $("#bank_id").selectpicker('val',data.bank_id);
                $("#name").val(data.name);
                $("#code").val(data.code);
                }

            });

        $("#submit").click(function(){
            if($("#hid").val() != ""){

            var id =$("#hid").val();

            var bank_id =$("#bank_id").val();
            var name =$("#name").val();
            var code =$("#code").val();

            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'put',
                'data' : {bank_id:bank_id,name:name,code:code},
                'url': 'branch/'+id,
                'async': false,
                success:function(data){
                if(data.validation_error){
                    validation_error(data.validation_error);//if has validation error call this function
                    }

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
                },
            });
            }
        });
    });

    $(document).on("click", ".delete", function(){

        var id = $(this).attr('data');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    'type': 'ajax',
                    'dataType': 'json',
                    'method': 'delete',
                    'url': 'branch/'+id,
                    'async': false,
                    success: function(data){

                        if(data){
                        Swal.fire(
                            'Deleted!',
                            'Designation has been deleted.',
                            'success'
                            );
                        setTimeout(function(){
                            location.reload();
                        }, 2000);

                        }

                    }
                });

            }
        });

    });

});

//Data Table show
function show_types(){

    $('#tblbranch').DataTable().clear();
    $('#tblbranch').DataTable().destroy();

    $("#tblbranch").DataTable({
        'processing': true,
        'serverSide': true,
        "bLengthChange": false,
        'ajax': {
                    'method': 'get',
                    'url': 'branch/create'
        },
        'columns': [
            {data: 'bank_name'},
            {data: 'code'},
            {data: 'name'},
            {
            data: null,
            render: function(d){
                var html = "";
                html+="<td><button class='btn btn-warning btn-sm edit' data='"+d.id+"'><i class='fas fa-edit'></i></button>";
                html+="&nbsp;<button class='btn btn-danger btn-sm delete' data='"+d.id+"'><i class='fas fa-trash'></i></button>";
                return html;

            }

            }
        ]
    });
}

function empty_form(){

    $("#branch").val("");
    $("#bank_id").val("");
    $("#name").val("");
    $("#code").val("");
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
