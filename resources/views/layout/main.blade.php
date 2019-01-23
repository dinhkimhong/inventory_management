<!DOCTYPE html>
<html lang="en">
<head>
<title>Sprout Berry</title>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="sprout, berry, sprout berry, project, learning, practicing, Web development, laravel, PHP, Javascrip">
<meta name="Description" content="Create 1 project of ERP using Laravel PHP">
<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.structure.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.structure.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.theme.css')}}">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.theme.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/style.css')}}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}"> --}}
<link href='https://fonts.googleapis.com/css?family=Tenali Ramakrishna' rel='stylesheet'>
<link rel="icon" href="{{ asset('favicon.ico')}} ">
  {{-------css data table----}}
<link href="{{ asset('css/buttons.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ asset('css/jquery.dataTables.min.css')}} " rel="stylesheet">

<style>
input[type="text"], option, #shipping_instruction, .custom-select{
	font-size: 21px;

}
{{---drop down--}}
.nav li a{
	color: #cccccc;
  	text-decoration: none;
  	display: block;
  	padding: 5px 24px;
  	line-height: 30px;
}
.nav li a:hover{
	color: #ffffff;
}

.dropdown .nav{
	display:none;
	position:absolute;
	z-index: 1;
}

.dropdown:hover .nav{
	display: block;
  	background-color: #D66A9B;

}

body .ui-autocomplete{
	font-family: 'Tenali Ramakrishna', tahoma, sans-serif;
  	color: #333;
  	background: #f7f5f0;
  	font-size: 21px;
  	border-radius: 5px;
  	z-index: 999999;
	}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
	border: none;
	background-color: #D66A9B;
}

main{
  min-height: 500px;
  
}

/*=====TOGGLE SWITCH===

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 24px;
}
/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #D66A9B;
}

input:focus + .slider {
  box-shadow: 0 0 1px #D66A9B;
}

input:checked + .slider:before {
  -webkit-transform: translateX(15px);
  -ms-transform: translateX(15px);
  transform: translateX(15px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
/* === END TOGGLE SWITCH====*/
/*=====BLINKING ERROR======*/
.blinking{
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    0%{     color: red;    }
    49%{    color: transparent; }
    50%{    color: transparent; }
    100%{   color: red;    }
}

.user-photo-nav{
  width: 40px;
  height: 40px;
  border-radius: 50px 50px 50px 50px;
}

</style>
</head>
<body>
<div class="alert alert-danger print-msg-success" role="alert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="print-msg-error" style="display: none">

</div>
<!--Header and Navigation -->
@if(session()->has('success'))
	<div class="alert alert-danger" role="alert">
	  	{{ session()->get('success')}}
	  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  	</button>
	</div>
@endif

@if(session()->has('fail'))
	<div class="alert alert-warning" role="alert">
	  	{{ session()->get('fail')}}
	  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  	</button>
	</div>
@endif

@if(session()->has('message'))
	<div class="alert alert-warning" role="alert">
	  	{{ session()->get('message')}}
	  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  	</button>
	</div>
@endif

<main class="container">

@yield('content')

</main>
<footer>
  <ul>
		<li><a href="#" class="social linkedin">LinkdedIn</a></li>
		<li><a href="#" class="social githut">Github</a></li>
	</ul>
	<p>Location: Squamish, BC</p>
</footer>

<script src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
    {{------js dataTable--------------}}
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('js/jszip.min.js')}}"></script>
<script src="{{ asset('js/pdfmake.min.js')}}"></script>    
<script src="{{ asset('js/vfs_fonts.js')}}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>  

<script type="text/javascript">
	$('#signin').on('click', function(){
		$('#signin-form').modal('show')
	});

	$('#signup').on('click',function(){
		$('#signup-form').modal('show')
	})

</script>

<script>
$(document).ready(function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    })
  });
</script>	
@yield('script') 
</body>
</html>