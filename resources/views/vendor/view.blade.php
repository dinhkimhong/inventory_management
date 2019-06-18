@extends('layout.main')

@section('content') 
    <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Vendor / <span class="text_change">View </span>vendor number {{$vendor->vendor_number}}</h5>
                  </div>
                  <div class="card-body">
                    <form class="p-3" action="{{route('updateVendor')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="vendor_number" class="col-form-label col-md-2">Vendor Number</label>
                            <input type="text" name="vendor_number" id="vendor_number" class="form-control col-md-2" readonly="true" value="{{$vendor->vendor_number}}">
                            <label for="vendor_name" class="col-form-label col-md-2">Name (*)</label>
                            <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6" value="{{$vendor->vendor_name}}" readonly="true">
                        </div>
                        <div class="form-group row">
                            <label for="address_1" class="col-form-label col-md-2">Address 1(*)</label>
                            <input type="text" name="address_1" id="address_1" class="form-control col-md-6" value="{{$vendor->address_1}}" readonly="true">
                            <label for="province_1" class="col-form-label col-md-2">Province 1(*)</label>
                            <input type="text" name="province_1" id="province_1" class="form-control col-md-2" value="{{$vendor->province_1}}" readonly="true">
                        </div>
                            <div class="form-group row">
                            <label for="address_2" class="col-form-label col-md-2">Address 2</label>
                            <input type="text" name="address_2" id="address_2" class="form-control col-md-6" value="{{$vendor->address_2}}" readonly="true">
                            <label for="province_2" class="col-form-label col-md-2">Province 2</label>
                            <input type="text" name="province_2" id="province_2" class="form-control col-md-2" value="{{$vendor->province_2}}" readonly="true">
                        </div>
                        <div class="form-group row">
                            <label for="country_code" class="col-form-label col-md-2">Country(*)</label>
                            <select name="country_code" id="country_code" class="form-control col-md-2 custom-select" disabled="true">
                                @foreach($countries as $country)
                                <option value="{{$country->country_code}}" @if($vendor->country_code == $country->country_code) selected="true" @endif>{{$country->country}}</option>
                                @endforeach
                            </select>
                            <label for="business_number" class="col-form-label col-md-2">Business Reg No.</label>
                            <input type="text" name="business_number" id="business_number" class="form-control col-md-2" value="{{$vendor->business_number}}" readonly="true">
                            <label for="website" class="col-form-label col-md-2">Website</label>
                            <input type="text" name="website" id="website" class="form-control col-md-2" value="www." value="{{$vendor->website}}" readonly="true">
                        </div>
                        <div class="form-group row">
                            <label for="tel" class="col-form-label col-md-2">Tel no.(*)</label>
                            <input type="text" name="tel" id="tel" class="form-control col-md-2" value="{{$vendor->tel}}" readonly="true">
                            <label for="fax" class="col-form-label col-md-2">Fax no.</label>
                            <input type="text" name="fax" id="fax" class="form-control col-md-2" value="{{$vendor->fax}}" readonly="true">
                        </div>
                            <div class="form-group row">
                            <label for="contact" class="col-form-label col-md-2">Contact</label>
                            <select name="title" id="title" class="form-control col-md-1 custom-select" disabled="true">
                                <option value=""></option>
                                @foreach($titles as $title)
                                <option value="{{$title->title}}" @if($vendor->title == $title->title) selected="true" @endif>{{$title->title}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="contact" id="contact" class="form-control col-md-1" value="{{$vendor->contact}}" readonly="true">
                            <label for="email" class="col-form-label col-md-2">Email address</label>
                            <input type="text" name="email" id="email" class="form-control col-md-2" value="{{$vendor->email}}" readonly="true">
                            <label for="position" class="col-form-label col-md-2">Position</label>
                            <input type="text" name="position" id="position" class="form-control col-md-2" value="{{$vendor->position}}" readonly="true">
                        </div>     
                        <div class="form-group row d-none">
                            <label for="created_by" class="col-form-label col-md-2">Created by</label>
                            <input type="text" name="created_by" id="created_by" class="form-control col-md-2" readonly="true" value="{{Auth::user()->id}}">
                        </div>   
                        <button id="back" class="btn btn-secondary">Back</button>
                        <button id="edit" class="btn btn-primary">Edit</button>
                        <button id="save" class="btn btn-success" hidden="true">Save</button>
                        <button id="delete" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('#edit').on('click',function(e){
        e.preventDefault();
        $(this).attr('hidden',true);
        $('.text_change').empty().append('Edit ');
        $('#save').attr('hidden',false);
        $('input').attr('readonly',false);
        $('select').attr('disabled',false);
        $('#vendor_number').attr('readonly',true);
        $('#created_by').attr('readonly',true);
    })

    $('#delete').on('click',function(e)
    {
        e.preventDefault();
        var number = $('#vendor_number').val()
        $.post("{{route('deleteVendor')}}", {vendor_number:number},function(data){
            // console.log('sucess');
                $(location).attr('href',"{{route('vendorIndex')}}");
                $('.print-msg-success').empty();
                $('.print-msg-success').append(data.success);
                $('.print-msg-success').css('display','block');
                $('.print-msg-error').css('display','none'); 
        });
    })

    $('#back').on('click',function(e){
        e.preventDefault();
        $(location).attr('href',"{{route('vendorIndex')}}");
    })

</script>    
   

@endsection