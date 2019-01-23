@extends('layout.main')
@include('layout.navhome')

@section('content')	
<h3 class="p-3">Purchase Order</h3>
<form action="{{route('viewPurchase')}}" method="GET">
	<div class="form-group row p-3">
        <label for="po_number" class="col-form-label col-md-2">Purchase Order no.</label>
        <input type="text" name="po_number" id="po_number" class="form-control col-md-2">
        <button type="submit" class="btn btn-save">Go</button>
    </div>
    <div class="p-3">
        <button id="createNew" class="btn btn-save">Create new purchase order</button>
    </div>
    
</form>
@endsection
@section('script')
<script type="text/javascript">
	$(document).on('click','#createNew',function(e){
		e.preventDefault();
		$(location).attr("href","{{ route('purchasePage') }}");
	})


</script>
@endsection