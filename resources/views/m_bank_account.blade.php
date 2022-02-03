@extends('layouts.app')

@section('content')
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Bank Account</h4>
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
                                <option value="">-- select Bank --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="levy">Branch Name</label>
                            <select name="branch_id" id="branch_id" class="form-control selectpicker" required data-live-search="true" data-size="5">
                                <option value="">-- select branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                        <label for="rate">Supplier ID</label>
                        <input type="text" class="form-control" id="supplier_id" name="supplier_id" placeholder="Enter Bank Code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="rate">Supplier Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rate">Supplier Email</label>
                            <input type="text" class="form-control" id="supplier_email" name="supplier_email" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rate">Supplier Telephone</label>
                            <input type="text" class="form-control" id="supplier_telephone" name="supplier_telephone" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rate">Account No</label>
                            <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="rate">Account Name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rate">Holder NIC</label>
                            <input type="text" class="form-control" id="holder_nic" name="holder_nic" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row" hidden>
                        <div class="form-group col-md-12">
                            <label for="rate">Action By</label>
                            <input type="text" class="form-control" id="action_by" name="action_by" placeholder="Enter Bank Name" required>
                        </div>
                    </div>
                    <div class="row" hidden>
                        <div class="form-group col-md-12">
                            <label for="rate">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Enter Bank Name" required>
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
            <h1 class="m-0 text-dark">Bank Account</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item"><a href="#">Bank</a></li>
              <li class="breadcrumb-item active">Bank Account</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addNew"><i class="fa fa-plus"></i> Add New Bank Account</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tblbankaccount">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Branch Name</th>
                                <th>Supplier Name</th>
                                <th>Account No</th>
                                <th>Account Name</th>
                                <th>Holder NIC</th>
                                <th>Status</th>
                                <th>Action</th>
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
    $(".bank_account_route").addClass('active');

    //csrf token error
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#bank_id").selectpicker();
    $("#branch_id").selectpicker();
    show_types();

    $(".addNew").click(function(){
        empty_form();
        $("#modal").modal('show');
        $(".modal-title").html('Save Bank Account');
        $("#submit").html('Save Bank Account');
        $("#submit").click(function(){
            $("#submit").css("display","none");
            var hid =$("#hid").val();
            //save bank
            if(hid == ""){
                var bank_id =$("#bank_id").val();
                var branch_id =$("#branch_id").val();
                var supplier_id =$("#supplier_id").val();
                var supplier_name =$("#supplier_name").val();
                var supplier_email =$("#supplier_email").val();
                var supplier_telephone =$("#supplier_telephone").val();
                var account_no =$("#account_no").val();
                var account_name =$("#account_name").val();
                var holder_nic =$("#holder_nic").val();

                $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'post',
                'data' : {bank_id:bank_id,branch_id:branch_id,supplier_id:supplier_id,supplier_name:supplier_name,supplier_email:supplier_email,supplier_telephone:supplier_telephone,account_name:account_name,account_no:account_no,holder_nic:holder_nic},
                'url' : 'bank_account',
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
        $(".modal-title").html('Edit Bank Account');
        $("#submit").html('Update Bank Account');

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': 'bank_account/'+id,
            'async': false,
            success: function(data){
                $("#bank_id").selectpicker('val',data.bank_id);
                $("#branch_id").selectpicker('val',data.branch_id);
                $("#supplier_id").val(data.supplier_id);
                $("#supplier_name").val(data.supplier_name);
                $("#supplier_email").val(data.supplier_email);
                $("#supplier_telephone").val(data.supplier_telephone);
                $("#account_no").val(data.account_no);
                $("#account_name").val(data.account_name);
                $("#holder_nic").val(data.holder_nic);
            }

        });

        $("#submit").click(function(){
            if($("#hid").val() != ""){
            var id =$("#hid").val();

            var bank_id = $("#bank_id").val();
            var branch_id = $("#branch_id").val();
            var supplier_id = $("#supplier_id").val();
            var supplier_name = $("#supplier_name").val();
            var supplier_email = $("#supplier_email").val();
            var supplier_telephone = $("#supplier_telephone").val();
            var account_no = $("#account_no").val();
            var account_name = $("#account_name").val();
            var holder_nic = $("#holder_nic").val();

            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'put',
                'data' : {bank_id:bank_id,branch_id:branch_id,supplier_id:supplier_id,supplier_name:supplier_name,supplier_email:supplier_email,supplier_telephone:supplier_telephone,account_name:account_name,account_no:account_no,holder_nic:holder_nic},
                'url': 'bank_account/'+id,
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
                        'url': 'bank_account/'+id,
                        'async': false,
                        success: function(data){

                        if(data){
                            Swal.fire(
                                'Deleted!',
                                'Bank Account has been deleted.',
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
        $('#tblbankaccount').DataTable().clear();
        $('#tblbankaccount').DataTable().destroy();

        $("#tblbankaccount").DataTable({
            'processing': true,
            'serverSide': true,
            "bLengthChange": false,
            "autoWidth": false,
            "aaSorting": [[0,'desc']],
            'ajax': {
                        'method': 'get',
                        'url': 'bank_account/create'
            },
            'columns': [
                {data: 'bank_name'},
                {data: 'branch_name'},
                {data: 'supplier_name'},
                {data: 'account_no'},
                {data: 'account_name'},
                {data: 'holder_nic'},
                {data: 'status',
                    "render":function(data,type,row,meta){
                            if(row.status==0)
                            {
                                return 'Pending'
                            }
                            if(row.status==1){
                                return 'Approved'
                            }
                            if(row.status==2){
                                return 'Rejected'
                            }
                        }
                },
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
    $("#bank_id").val("");
    $("#branch_id").val("");
    $("#supplier_id").val("");
    $("#supplier_name").val("");
    $("#supplier_email").val("");
    $("#supplier_telephone").val("");
    $("#account_no").val("");
    $("#account_name").val("");
    $("#holder_nic").val("");

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