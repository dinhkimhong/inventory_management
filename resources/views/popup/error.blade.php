<div class="modal fade" id="error_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body print-msg-error">
      	@foreach ($errors->all() as $error)
      	<p> {{ $error }} </p>
      	@endforeach
      </div>  
    </div>
  </div>
</div>