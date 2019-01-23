@extends('layout.main')
@include('layout.navhome')

@section('content')
<style type="text/css">
ul {
	list-style-type: none;
}

ul li .btn{
	margin-bottom: 15px;	
  	font-size: 21px;
  	background-color: #D66A9B;
  	color: #cccccc;
  	width: 240px;
  	text-align: left;
}

ul li .btn:hover{
	background-color: #D66A9B;
	color: #ffffff;
}
	
</style>

<h3 class="pt-3">Bill of Material</h3>
<ul>
	<li><a class="btn" href="{{ route('finishedPage') }}" role="button">Create Finished Goods</a></li>
	<li><a class="btn" href="{{ route('semiPage') }}" role="button">Create Semifinished Goods</a></li>
	<li><a class="btn" href="{{ URL::to('material/create')}}" role="button">Create Raw Material</a></li>
</ul>
@endsection