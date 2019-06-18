@extends('layout.main')

@section('content')	
            <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Purchase Order</h5>
                  </div>
                  <div class="card-body">
                        <form>
                        	<div class="form-group row p-3">
                                <label for="po_number" class="col-form-label col-md-2">Purchase Order no.</label>
                                <input type="text" name="po_number" id="po_number" class="form-control col-md-2">
                                <button type="submit" class="btn btn-primary my-auto">Go</button>
                            </div>
                            
                        </form>
                        <button id="createNew" class="btn btn-success">Create new purchase order</button>
                </div>
            </div>
        </div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).on('click','#createNew',function(e){
		e.preventDefault();
		$(location).attr("href","{{ route('purchasePage') }}");
	})

    $('form').on('submit',function(e){
        e.preventDefault();
        const po_number = $('#po_number').val();
        $(location).attr('href',`purchase/view/${po_number}`);
    })


</script>
@endsection