@extends('layout.main')

@section('content')
            <div class="row">
              <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Material </h5>
                  </div>
                  <div class="card-body">
						<div class="row">
						    <input type="text" name="term" id="search_material" class="form-control" placeholder="Seach material...">
						</div>                          
						<form>
						    <div class="form-group row my-3">
						            <label for="material_number" class="col-form-label col-md-2">Material Number</label>
						            <input type="text" name="material_number" id="material_number" class="form-control col-md-2" required="true">
						            <input type="text" id="material_description" class="form-control col-md-6" readonly="true">
									<button type="submit" class="btn btn-primary my-auto" id="view_material">Go</button>

						    </div>
						</form>
						<div class="row">
							<button id="createNew" class="btn btn-success">Create new material</button>
						
<!-- 						@if(Auth::user()->hasRole('AD'))
						    <form action="{{route('importMaterial')}}" method="POST" enctype="multipart/form-data">
						        @csrf
						        <input type="file" name="material">
						        <button type="submit" class="btn btn-save">Import</button>
						    </form>
						@endif -->

							<button type="button" class="btn btn-info" onclick="window.location.href='{{route('exportMaterial')}}'">Download</button>
						</div>
                  </div>
         
               </div>
      </div>
    </div>

@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){
		$('#createNew').on('click',function(e){
			e.preventDefault();
			$(location).attr('href',"{{route('materialPage')}}");
		})

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

		$('#view_material').on('click',function(e){
			e.preventDefault();
			var number = $('#material_number').val();
			$(location).attr('href',`material/view/${number}`);
			// alert(number);
		})
	})

	


</script>
@endsection