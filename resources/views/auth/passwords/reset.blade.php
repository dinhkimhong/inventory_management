@extends('layout.main')
@include('layout.navhome')
@include('popup.login')
@include('popup.signup')

@section('content')
  <h3 class="pt-3">Reset password</h3>
  <form method="POST" action="{{ route('password.request') }}">
  	@csrf
  	<input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group row">
          <label for="email1" class="col-form-label col-md-2">Email</label>
            <input type="text" name="email" id="email1" class="form-control col-md-4" >
      </div>
      <div class="form-group row">
        <label for="password1" class="col-form-label col-md-2">New password</label>
        <input type="password" class="form-control col-md-4" id="password1" name="password">
      </div>
      <div class="form-group row">
        <label for="password-confirm1" class="col-form-label col-md-2">Confirm Password</label>
        <input type="password" class="form-control col-md-4" id="password-confirm1" name="password_confirmation">
      </div>

    <button type="submit" class="btn btn-save">Reset Password</button>
</form> 

@endsection