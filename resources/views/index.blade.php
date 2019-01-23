@extends('layout.main')
@include('layout.navhome')

@section('content')
@include('content.home')
@include('popup.login')
@include('popup.signup')

@endsection