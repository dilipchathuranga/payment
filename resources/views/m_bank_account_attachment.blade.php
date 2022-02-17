@extends('layouts.app')

@section('content')
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Attachment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myForm" enctype="multipart/form-data">
                    <input type="hidden" id="hid" name="hid">
                    <input type="text" id="bank_id" name="bank_id" value="{{ $attchment->bank_id }}" hidden>
                    <input type="text" id="supplier_id" name="supplier_id" value="{{ $attchment->supplier_id }}" hidden>
                    <div class="row">
                        <div class="form-group col-md-12">
                        <label for="rate">Attachment Desception</label>
                        <textarea type="text" class="form-control" id="document_main" name="document_main" placeholder="Enter Attachment Desception" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="rate">Account Attachment</label>
                            <input type="file" class="form-control" id="document_path" name="document_path">
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
            <h1 class="m-0 text-dark">{{ $attchment->supplier_name }}</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item"><a href="#">Bank</a></li>
              <li class="breadcrumb-item active">Bank Attachment</li>
            </ol>
          </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addNew"><i class="fa fa-plus"></i> Add New Attachment</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tbl_bank_attachment">
                        <thead>
                            <tr>
                                <th style="width:20%">Bank Name</th>
                                <th style="width:20%">Supplier Name</th>
                                <th style="width:20%">Document Description</th>
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

    //csrf token error
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    show_types();

    $(document).on("blur",".form-control",function(){
        $("#submit").css("display","block");
    });

    $(".addNew").click(function(){
        empty_form();
        $("#modal").modal('show');
        $(".modal-title").html('Save Agreement');
        $("#submit").html('Save Agreement');
        $("#submit").click(function(){
            var hid =$("#hid").val();
            //save agreement
            if(hid == ""){
                var bank_id = $("#bank_id").val();
                var supplier_id = $("#supplier_id").val();
                var document_main = $("#document_main").val();

                var formData = new FormData($('#myForm')[0]);

                $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'post',
                'data' : formData,
                'url' : "{{ url('bank_account_attachment') }}",
                'processData': false,
                'contentType': false,
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

    $(document).on('click', '.edit',function(){
        var id = $(this).attr('data');
        empty_form();
        $("#hid").val(id);
        $("#modal").modal('show');
        $(".modal-title").html('Edit Attachment');
        $("#submit").html('Update Attachment');

        $.ajax({
            'type': 'ajax',
            'dataType': 'json',
            'method': 'get',
            'url': "{{ url('bank_account_attachment') }}/"+id,
            'async': false,
            success: function(data){
            // console.log(data.id);
                $("#hid").val(data.id);
                $("#bank_id").val(data.bank_id);
                $("#supplier_id").val(data.supplier_id);
                $("#document_main").val(data.document_main);
            }
        });

        $("#submit").click(function(){
            if($("#hid").val() != ""){
            var id =$("#hid").val();

            var bank_id = $("#bank_id").val();
            var supplier_id = $("#supplier_id").val();
            var document_main = $("#document_main").val();

            $.ajax({
                'type': 'ajax',
                'dataType': 'json',
                'method': 'put',
                'data' : {bank_id:bank_id,supplier_id:supplier_id,document_main:document_main},
                'url': "{{ url('bank_account_attachments') }}/"+id,
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
                        'url': "{{ url('bank_account_attachment') }}/"+id,
                        'async': false,
                        success: function(data){

                        if(data){
                            Swal.fire(
                                'Deleted!',
                                'Attachment has been deleted.',
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

        var id = "{{ json_encode($attchment->bank_id) }}";


            $('#tbl_bank_attachment').DataTable().clear();
            $('#tbl_bank_attachment').DataTable().destroy();

            $("#tbl_bank_attachment").DataTable({
                'processing': true,
                'serverSide': true,
                "bLengthChange": false,
                'ajax': {
                            'method': 'get',
                            'url': '/bank_account_attachment/show_attachment/'+id,
                        },
                'columns': [
                    {data: 'bank_id'},
                    {data: 'supplier_id'},
                    {data: 'document_main'},

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
    $("#hid").val("");
    $("#document_main").val("");
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
