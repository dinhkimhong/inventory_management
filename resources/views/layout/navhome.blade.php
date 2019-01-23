<nav class="navbar navbar-expand-lg">
	<div class="container">
	  <span class="navbar-item" style="text-align:left;"><a class="nav-link pl-0" href="{{URL::to('/')}}">SproutBerry</a></span>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	   <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
	    <ul class="navbar-nav float-right">
	    	@guest
	      <li id="signin" class="nav-item"><a class="nav-link" href="#">Log In</a></li>
	    	<li id="signup" class="nav-item"><a class="nav-link" href="#">Sign Up</a></li>
	    	@else
			<li class="nav-item dropdown">
		       <a class="nav-link" href="#">Master Data</a>
		       	<ul class="nav">
					<li><a href="{{route('materialIndex')}}">Material</a></li>
<!-- 					<li><a href="#">Customer</a></li> -->
					<li><a href="{{route('vendorIndex')}}">Vendor</a></li>
				</ul>
		    </li>
		    <li class="nav-item">
		       <a class="nav-link" href="#">Sales</a>
		    </li>
		    <li class="nav-item dropdown">
		   	   <a class="nav-link" href="#">Purchasing</a>
		       	<ul class="nav">
					<li><a href="{{route('purchaseIndex')}}">Purchase</a></li>
					<li><a href="{{route('inboundIndex')}}">Inbound</a></li>
				</ul>		   	   
		    </li>
		    <li class="nav-item dropdown">
		   	   <a class="nav-link" href="#">Production</a>
		       	<ul class="nav">
					<li><a href="{{route('bomPage')}}">BOM</a></li>
					<li><a href="{{route('projectIndex')}}">Project</a></li>
				</ul>		   	   
		    </li>
		    <li class="nav-item">
		   	   <a class="nav-link" href="#">Report</a>
		    </li>
		    <li class="nav-item dropdown">
		    	<a><img src="{{route('showPhoto')}}" alt="{{Auth::user()->username}}" class="user-photo-nav"></a>
		       <!-- <a class="nav-link" href="#">{{ Auth::user()->username}}</a> -->
		       	<ul class="nav">
					<li><a href="{{route('settingPage')}}">Setting</a></li>
					<li><a href="{{route('logout')}}"" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">LogOut</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>


					</li>
				</ul>
		    </li>
	    	@endguest
	    </ul>
	  </div>
  	</div>
</nav>