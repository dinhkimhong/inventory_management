@extends('layout.main')
@include('layout.navhome')

@section('content')	
<h3 class="pt-3">Vendor</h3>
<input type="text" name="term" id="search_vendor" class="form-control col-md-10" placeholder="Seach vendor...">
<form action="{{route('viewVendor')}}" method="GET">
	<div class="form-group row pt-3">
        <label for="vendor_number" class="col-form-label col-md-2">Vendor Number</label>
        <input type="text" name="vendor_number" id="vendor_number" class="form-control col-md-2">
        <input type="text" id="vendor_name" class="form-control col-md-6" readonly="true">
        <button type="submit" class="btn btn-save">Go</button>
    </div>
    <div class="pb-3">
        <button id="createNew" class="btn btn-save">Create new vendor</button>
    </div>
    
</form>
@endsection
@section('script')
<script type="text/javascript">

	$('#search_vendor').autocomplete({
		source: "{{route('searchVendor')}}",
		minLength:2,
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
				// $('#vendor_name').val(vendor_info.vendor_name);
				console.log(vendor_info);
			}
		})
	})


	$(document).on('click','#createNew',function(e){
		e.preventDefault();
		$(location).attr('href',"{{route('vendorPage')}}");
	})




</script>
@endsection