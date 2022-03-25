@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h1 class="m-0 text-dark">Profile</h1>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">User Profile</li>
            </ol>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="col-md-12">
            <div class="alert alert-success">
                <ul>
                    {{ session()->get('message') }}
                </ul>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="col-md-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    <div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <form role="form">
            <div class="card-header">
                <h3 class="card-title">User Profile</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ $user->name }}"  name="username" placeholder="Enter Username" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" name="email" placeholder="Enter email" readonly>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-primary">
            <form class="form" id="myForm" action="" method="post">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                    <label for="password">Re-Enter New Password</label>
                    <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" placeholder="Re-Enter New Password" required>
                </div>
                </form>
                                 <input type="text" id="user_id" value="{{Auth::user()->id }}" hidden>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary submit">Submit</button>
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



$(".submit").click(function(){

      var current = $("#current_password").val();

                var password = $("#new_password").val();
                var confirmPassword = $("#password_confirmation").val();

                if (password != confirmPassword) {
                    toastr.error("Passwords do not match.");
                    return this;
                }
                var ajaxConfig = {
                    method: "POST",
                    url: "change_password",
                    data: {
                        "current_password":current,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    async: true
                }

                $.ajax(ajaxConfig).done(function(response, statusText, jxhr) {
                 if(response){
                     console.log('matched');
                        let ajax_req={
                            method: "POST",
                            url: "https://maga.engineering/api/update_password/"+$("#user_id").val(),
                            data: {
                                    "password":password,
                                    "api_token":'MAGA_AUHT_00001'
                            },
                            async: true
                        }
                     $.ajax(ajax_req).done(function(res){
                            $("#current_password").val('');
                            $("#new_password").val('');
                            $("#password_confirmation").val('');
                            toastr.error('password updated');
                     }).fail(function(res){
                            console.log(res);
                     });
                 }
                }).fail(function(jxhr, statusText, error) {
                    toastr.error('Invalid current password');
                    console.console.log('failed');
                });

    // $("#myForm").attr('action', 'change_password') ;
    // $("#myForm").attr('method', 'get') ;
    // $('#myForm').submit();
});
});

</script>
@endsection
