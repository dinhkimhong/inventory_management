<div class="modal fade" id="signin-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Sign In</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		 <form action="{{route('login')}}" method="POST">
		 	@csrf
		  <div class="form-group">
		    <label for="email">Email address</label>
		    <input type="text" class="form-control" id="email" name="email">
		          @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                   @endif
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" class="form-control" id="password" name="password">
                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
		  </div>

		  <button type="submit" class="btn">Login</button>
		  <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
		</form>
<!--     <div class="pt-3">
      <a href="{{url('auth/facebook')}}" class="btn">Log in with Facebook</a>
      <a href="{{url('auth/facebook')}}" class="btn">Log in with Google</a>
    </div> -->
      </div>  
    </div>
  </div>
</div>