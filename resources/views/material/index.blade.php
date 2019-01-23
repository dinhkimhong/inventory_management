@extends('layout.main')
@include('layout.navhome')

@section('content')
<h3 class="pt-3">Material</h3>
<div class="row p-3">
	<input type="text" name="term" id="search_material" class="form-control col-md-10" placeholder="Seach material...">
</div>							
<form action="{{route('viewMaterial')}}" method="GET">
        <div class="form-group row">
        	<label for="material_number" class="col-form-label col-md-2">Material Number</label>
            <input type="text" name="material_number" id="material_number" class="form-control col-md-2">
	        <input type="text" id="material_description" class="form-control col-md-6" readonly="true">
	    	<button type="submit" class="btn btn-save">Go</button>
	    </div>
    	<div class="pb-3">
        	<button id="createNew" class="btn btn-save">Create new material</button>
    	</div>
</form>
@if(Auth::user()->hasRole('AD'))
	<form action="{{route('importMaterial')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="file" name="material">
		<button type="submit" class="btn btn-save">Import</button>
	</form>
@endif

	<button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='{{route('exportMaterial')}}'" style="background-color: #D66A9B; border: none; color: #cccccc; font-size: 21px;">Download</button>

@endsection
@section('script')
<script type="text/javascript">

	$('#search_material').autocomplete({
		source: '{!!URL::route('searchMaterial') !!}',
		minLength: 1,
		//autoFocus:true,
		select:function(key,value){
			$('#material_number').val(value.item.id);
			$('#material_description').val(value.item.value);
		}		
	});

	$('#material_number').on('change',function(){
		var number = $('#material_number').val();
		var dataNumber = {'material_number':number};
		$.ajax({
			type:'GET',
			url: '{{route('findMaterialInfo')}}',
			datatype: 'json',
			data: dataNumber,
			success: function(material_info){
				$('#material_description').val(material_info.material_description);
			}
		})
	})

	$(document).on('click','#createNew',function(e){
		e.preventDefault();
		$(location).attr('href',"{{route('materialPage')}}");
	})


</script>
@endsection