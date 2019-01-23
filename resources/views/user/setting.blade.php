@extends('layout.main')
@include('layout.navhome')
@include('popup.password')

@section('content') 

<h3 class="pt-3">Setting</h3>
<form class="pb-3" action="{{route('updateUser')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
<div class="col">

            <label for="name" >Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->username}}">

            
            <label for="password" >Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password1" class="form-control" value="123456" readonly="true">
                <button class="btn btn-save" id="change_password">Change password</button>
            </div>

            <label for="email" >Email</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" readonly="true">


</div>
<div class="col">
        <div class="form-group">
        <label for="photo">Photo (* less than 1MB) </label>
        <div>
            <img src="{{route('showPhoto')}}" alt="{{Auth::user()->username}}" width="175" height="175" class="student-photo" id="showPhoto">
            <input type="file" name="photo" id="photo" accept="image/x-png,image/png,image/jpg,image/jpeg" hidden="true">
            <input type="button" name="browse_file" id="browse_file" class="form-control btn btn-save" value="Browse" style="width: 175px;">
        </div>
     </div>
</div>      
</div>  
<div class="pt-3">  
    <button type="submit" class="btn btn-save">Save</button>
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
    $('#browse_file').on('click',function(){
        $('#photo').click();
    })  

    $('#photo').on('change',function(e){
        showFile(this,'#showPhoto');
    })

    function showFile(fileInput, img, showName){
        if(fileInput.files[0]){
            var reader = new FileReader();
            reader.onload= function(e){
                $(img).attr('src',e.target.result);
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
        $(showName).text(fileInput.files[0].name);
    }

    $('#cancel').on('click',function(e){
        e.preventDefault();
        $(location).attr('href',"{{route('home')}}");
    })

    $('#change_password').on('click',function(e){
        e.preventDefault();
        $('#password_reset').modal('show');
    })

</script>

@endsection