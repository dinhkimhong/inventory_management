@extends('layout.main')
@include('layout.navhome')
@include('../popup.error')
@section('content') 
<header>
    <h3 class="pt-3">Material</h3>
    <p id="error" style="float:right; display: none"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
</header>
<form action="{{route('createMaterial')}}" method="POST">
    @csrf
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Basic data</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="accounting-tab" data-toggle="tab" href="#accounting" role="tab" aria-controls="accounting" aria-selected="false">Accounting</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="planning-tab" data-toggle="tab" href="#planning" role="tab" aria-controls="planning" aria-selected="false">Planning</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="costing-tab" data-toggle="tab" href="#costing" role="tab" aria-controls="costing" aria-selected="false">Costing</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active p-3" id="data" role="tabpanel" aria-labelledby="data-tab">
    <div class="form-group row">
        <label for="material_number" class="col-form-label col-md-2">Material Number</label>
        <input type="text" name="material_number" id="material_number" class="form-control col-md-2" readonly="true"><span class="glyphicon glyphicon-envelope"></span>
        <label for="material_description" class="col-form-label col-md-2">Description(*)</label>
        <input type="text" name="material_description" id="material_description" class="form-control col-md-6">
    </div>
    <div class="form-group row">
        <label for="mfg_material_number" class="col-form-label col-md-2">Mfg Number</label>
        <input type="text" name="mfg_material_number" id="mfg_material_number" class="form-control col-md-2">
        <label for="unit" class="col-form-label col-md-2">Unit (*)</label>
            <select class="form-control col-md-2 custom-select" name="unit" id="unit">
                <option value=""></option>
                @foreach ($units as $u)
                <option value="{{$u->unit}}">{{$u->unit}}</option>
                @endforeach
            </select>
        <label for="material_group_id" class="col-form-label col-md-2">Material Group (*)</label>
            <select name="material_group_id" id="material_group_id" class="form-control col-md-2 custom-select">
                <option value=""></option>
                @foreach ($material_groups as $mg)
                <option value="{{$mg->material_group_id}}">{{$mg->material_group}}</option>
                @endforeach
            </select>
    </div>
    <div class="form-group row">
        <label for="manufacturer" class="col-form-label col-md-2">Manufacturer</label>
        <input type="text" name="manufacturer" id="manufacturer" class="form-control col-md-3">
        <label for="weight" class="col-form-label col-md-2">Weight/unit (Kg)</label>
        <input type="text" name="weight" id="weight" class="form-control col-md-2">        
        <label for="origin" class="col-form-label col-md-1">Origin(*)</label>
        <select name="origin" id="origin" class="form-control col-md-2 custom-select"> 
            <option value=""></option>
            @foreach($countries as $c)
            <option value="{{$c->country_code}}">{{$c->country}}</option>
            @endforeach
        </select>
    </div>   
  </div>
  <div class="tab-pane fade p-3" id="accounting" role="tabpanel" aria-labelledby="accounting-tab">
    <div class="form-group row">
        <label for="gst" class="col-form-label col-md-1">GST</label>
        <div class="col-md-3">
            <label class="switch">
                  <input type="checkbox" name="gst" id="gst">
                  <span class="slider round"></span>
            </label>
        </div>
        <label for="import_tax" class="col-form-label col-md-2">Import Tax</label>
        <input type="text" name="import_tax" id="import_tax" class="form-control col-md-2">
        <label for="discount" class="col-form-label col-md-2">Discount</label>
        <input type="text" name="discount" id="discount" class="form-control col-md-2">



<!--         <label for="gst" class="col-form-label col-md-2">GST (*)</label>
        <input type="text" name="gst" id="gst" class="form-control col-md-2">
        <label for="pst" class="col-form-label col-md-2">PST (*)</label>
        <input type="text" name="pst" id="pst" class="form-control col-md-2">
        <label for="hst" class="col-form-label col-md-2">HST (*)</label>
        <input type="text" name="hst" id="hst" class="form-control col-md-2"> -->
    </div>  
    <div class="form-group row">
        <label for="pst" class="col-form-label col-md-1">PST</label>
        <div class="col-md-3">
            <label class="switch">
                  <input type="checkbox" name="pst" id="pst">
                  <span class="slider round"></span>
            </label>
        </div>

        <label for="export_tax" class="col-form-label col-md-2">Export Tax</label>
        <input type="text" name="export_tax" id="export_tax" class="form-control col-md-2">
    </div>
    <div class="form-group row">
        <label for="hst" class="col-form-label col-md-1">HST</label>
        <div class="col-md-3">
            <label class="switch">
                  <input type="checkbox" name="hst" id="hst">
                  <span class="slider round"></span>
            </label>
        </div>
        <label for="tarrif_code" class="col-form-label col-md-2">Tarrif Code(*)</label>
        <input type="text" name="tarrif_code" id="tarrif_code" class="form-control col-md-2">

    </div>

  </div>
  <div class="tab-pane fade p-3" id="planning" role="tabpanel" aria-labelledby="planning-tab">
    <div class="form-group row">
        <label for="inventory_quantity" class="col-form-label col-md-2">Quantity</label>
        <input type="text" name="inventory_quantity" id="inventory_quantity" class="form-control col-md-2" readonly="true">
    </div>
    <div class="form-group row">
        <label for="planning" class="col-form-label col-md-2">Planning</label>
        <label class="switch">
              <input type="checkbox" name="planning" id="planning_1">
              <span class="slider round"></span>
        </label>

        <!-- <label>
            <input type="radio" name="planning" id="planning_1" value="1" required checked>
            Yes                                    
        </label>
         <label>
            <input type="radio" name="planning" id="planning_1" value="0" required>
            No                                   
        </label> -->       
    </div>
        <div class="form-group row">
        <label for="safety_stock" class="col-form-label col-md-2">Safety Stock</label>
        <input type="text" name="safety_stock" id="safety_stock" class="form-control col-md-2">
    </div>        
  </div>
  <div class="tab-pane fade p-3" id="costing" role="tabpanel" aria-labelledby="costing-tab">
    <div class="form-group row">
        <label for="purchasing_price" class="col-form-label col-md-2">Purchasing Price</label>
        <input type="text" name="purchasing_price" id="purchasing_price" class="form-control col-md-2" readonly="true">
    </div>
    <div class="form-group row">
        <label for="selling_price" class="col-form-label col-md-2">Selling Price</label>
        <input type="text" name="selling_price" id="selling_price" class="form-control col-md-2" readonly="true">
    </div>
    <div class="form-group row">
        <label for="moving_price" class="col-form-label col-md-2">Moving Price</label>
        <input type="text" name="moving_price" id="moving_price" class="form-control col-md-2" readonly="true">
        <label for="stock_value" class="col-form-label col-md-2">Stock Value</label>
        <input type="text" name="stock_value" id="stock_value" class="form-control col-md-2" readonly="true">        
        <label for="currency" class="col-form-label col-md-2">Currency (*)</label>
            <select name="currency" id="currency" class="form-control col-md-2 custom-select">
                <option value=""></option>
                @foreach($currencies as $cu)
                <option value="{{$cu->currency}}">{{$cu->currency}}</option>
                @endforeach
            </select>
    </div>    
  </div>
</div>
<div class="p-3">
<!--     <div class="form-group row">
        <label for="created_by" class="col-form-label col-md-2">Created by</label>
        <input type="text" id="created_by" class="form-control col-md-2" readonly="true" value="{{ Auth::user()->username }}">
    </div> -->   
    <button type="submit" class="btn btn-save">Save</button>
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</div> 
</form>
@endsection
@section('script')
<script type="text/javascript">
    stock_value();

    $('form').on('submit',function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        console.log(data);
        $.post(url, data, function(data){
            if($.isEmptyObject(data.fail))
            {
                // console.log('success');
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

    function stock_value(){
        var inventory_quantity = $('#inventory_quantity').val();
        var moving_price = $('#moving_price').val();
        var value = (inventory_quantity * moving_price);
        $('#stock_value').val(value);
    }

    $(document).on('click','#cancel',function(e){
        e.preventDefault();
        $(location).attr('href',"{{route('materialIndex')}}");
    })




</script>


@endsection