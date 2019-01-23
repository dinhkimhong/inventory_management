@extends('layout.main')
@include('layout.navhome')
@include('popup.login')
@include('popup.signup')

@section('content')
	<h3 class="pt-3">Reset password</h3>
	<form method="POST" action="{{ route('password.email') }}">
		@csrf
        <div class="form-group row">
        	<label for="email" class="col-form-label col-md-1">Email</label>
            <input type="text" name="email" class="form-control col-md-4">
	        <button type="submit" class="btn btn-save">Send email</button>
	    </div>

@endsection


