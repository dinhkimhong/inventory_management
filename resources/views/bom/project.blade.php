@extends('layout.main')
@include('layout.navhome')

@section('content')	
<h3 class="p-3">Project</h3>
<form action="{{ route('projectPage')}}" method="GET">
	<div class="form-group row p-3">
        <label for="project_number" class="col-form-label col-md-2">Project Number</label>
        <input type="text" name="project_number" id="project_number" class="form-control col-md-2">
        <button type="submit" class="btn btn-save">Create</button>
    </div>
   
</form>
@endsection
