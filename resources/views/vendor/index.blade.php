@extends('layout.main')

@section('content')	
    <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Vendor</h5>
                  </div>
                  <div class="card-body">
                  	<div class="row">
						<input type="text" name="term" id="search_vendor" class="form-control col-md-10" placeholder="Seach vendor...">
					</div>
					<form class="mt-3" method="GET">
							<div class="form-group row">
						        <label for="vendor_number" class="col-form-label col-md-2">Vendor Number</label>
						        <input type="text" name="vendor_number" id="vendor_number" class="form-control col-md-2">
						        <input type="text" id="vendor_name" class="form-control col-md-6" readonly="true">
						        <button type="submit" class="btn btn-primary my-auto">Go</button>
						    </div>
			    
					</form>
					<div class="row">
					    <button id="createNew" class="btn btn-success">Create new vendor</button>
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
			$(location).attr('href',"{{route('vendorPage')}}");
		})

		$('#search_vendor').autocomplete({
			source: "{{route('searchVendor')}}",
			minLength:1,
			select:function(key,value){
				$('#vendor_number').val(value.item.id);
				$('#vendor_name').val(value.item.value);
			}
		})


		$('#vendor_number').on('change',function(){
			var number = $('#vendor_number').val();
			var dataNumber = {'vendor_number': number};
			$.ajax({
				type:'GET',
				url: "{{route('findVendorInfo')}}",
				datatype: 'json',
				data: dataNumber,
				success:function(vendor_info){
					$('#vendor_name').val(vendor_info.vendor_name);
				}
			})
		})

		$('form').on('submit',function(e){
			e.preventDefault();
			const vendor_number = $('#vendor_number').val();
			$(location).attr('href',`vendor/view/${vendor_number}`);
		})
	})
</script>
@endsection