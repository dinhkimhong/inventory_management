@extends('layout.main')
@include('layout.navhome')
@include('../popup.error')

@section('content') 
<header>
    <h3 class="pt-3">Vendor</h3>
    <p id="error" style="float:right; display: none"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
</header>
<form class="p-3" action="{{route('createVendor')}}" method="POST">
    @csrf
    <div class="form-group row">
        <label for="vendor_number" class="col-form-label col-md-2">Vendor Number</label>
        <input type="text" name="vendor_number" id="vendor_number" class="form-control col-md-2" readonly="true">
        <label for="vendor_name" class="col-form-label col-md-2">Name (*)</label>
        <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6">
    </div>
    <div class="form-group row">
        <label for="address_1" class="col-form-label col-md-2">Address 1(*)</label>
        <input type="text" name="address_1" id="address_1" class="form-control col-md-6">
        <label for="province_1" class="col-form-label col-md-2">Province 1(*)</label>
        <input type="text" name="province_1" id="province_1" class="form-control col-md-2">
    </div>
        <div class="form-group row">
        <label for="address_2" class="col-form-label col-md-2">Address 2</label>
        <input type="text" name="address_2" id="address_2" class="form-control col-md-6">
        <label for="province_2" class="col-form-label col-md-2">Province 2</label>
        <input type="text" name="province_2" id="province_2" class="form-control col-md-2">
    </div>
    <div class="form-group row">
        <label for="country_code" class="col-form-label col-md-2">Country(*)</label>
        <select name="country_code" id="country_code" class="form-control col-md-2 custom-select">
            <option value=""></option>
            @foreach ($countries as $c)
            <option value="{{$c->country_code}}">{{$c->country}}</option>
            @endforeach
        </select>
        <label for="business_number" class="col-form-label col-md-2">Business Reg No.</label>
        <input type="text" name="business_number" id="business_number" class="form-control col-md-2">
        <label for="website" class="col-form-label col-md-2">Website</label>
        <input type="text" name="website" id="website" class="form-control col-md-2" value="www.">
    </div>
    <div class="form-group row">
        <label for="tel" class="col-form-label col-md-2">Tel no.(*)</label>
        <input type="text" name="tel" id="tel" class="form-control col-md-2">
        <label for="fax" class="col-form-label col-md-2">Fax no.</label>
        <input type="text" name="fax" id="fax" class="form-control col-md-2">
    </div>
        <div class="form-group row">
        <label for="contact" class="col-form-label col-md-2">Contact</label>
        <select name="title" id="title" class="form-control col-md-1 custom-select" placeholder="title...">
            <option value=""></option>
            @foreach ($titles as $t)
            <option value="{{$t->title}}">{{$t->title_description}}</option>
            @endforeach      
        </select> 
        <input type="text" name="contact" id="contact" class="form-control col-md-1">
        <label for="email" class="col-form-label col-md-2">Email address</label>
        <input type="text" name="email" id="email" class="form-control col-md-2">
        <label for="position" class="col-form-label col-md-2">Position</label>
        <input type="text" name="position" id="position" class="form-control col-md-2">
    </div>     
    <div class="form-group row">
        <label for="created_by" class="col-form-label col-md-2">Created by</label>
        <input type="text" name="created_by" id="created_by" class="form-control col-md-2" readonly="true" value="{{Auth::user()->id}}">
    </div>   
    <button type="submit" class="btn btn-save">Save</button>
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</form>
@endsection

@section('script')
    
<script type="text/javascript">
    $('form').on('submit',function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        //console.log(data);
        $.post(url, data, function(data){
            if($.isEmptyObject(data.fail))
            {
                $('.print-msg-success').empty();
                $('.print-msg-success').append(data.success);
                $('.print-msg-success').css('display','block');
                $('#error').css('display','none');
                $('form').trigger('reset');        
            } else{
                $('#error').css('display','block');
                printFailMsg(data.fail);
            }

        });
        
    })

    function printFailMsg(msg){
        $('#error').on('click',function(){
            $('#error_box').modal('show')
        });
        $('.print-msg-error').empty();
        $('.print-msg-success').css('display','none');
        $.each(msg,function(key,value){
            $('.print-msg-error').append(
                '<p>'+value + '</p>'
            );
        })
    }

    $('#cancel').on('click',function(e){
        e.preventDefault();
        $(location).attr('href',"{{route('vendorIndex')}}");
    })

</script>    
    

@endsection