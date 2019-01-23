<div class="modal fade" id="password_reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Password Change</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		 <form action="{{ route('resetPassword')}}" method="POST">
		 	@csrf
		  <div class="form-group">
		    <label for="password">Old password</label>
		    <input type="password" class="form-control" id="password" name="password">
		  </div>
		  <div class="form-group">
		    <label for="new_password">New Password</label>
		    <input type="password" class="form-control" id="new_password" name="new_password">
		  </div>
      <div class="form-group">
        <label for="password-confirm">Confirm Password</label>
        <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
      </div>
		  <button type="submit" class="btn">Save</button>
		</form>
      </div>  
    </div>
  </div>
</div>