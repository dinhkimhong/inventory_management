@extends('layout.main')
@include('layout.navhome')
@include('popup.search_vendor')
@include('popup.search_material')
@include('popup.error')

@section('content') 
<style type="text/css">
    .quantity,.unit_price,.amount,.import_duty,.freight_handling_cost,#total_amount,#total_import_duty,#total_freight_handling_cost,#total_cost{
        text-align: right;
    }

</style>
<header>
    <h3 class="pt-3">Purchase Order</h3>
    <form action="{{ route('printPurchase',$purchase->po_number)}}" method="GET"><button id="print" class="btn btn-save" style="float: right;">Print</button></form>
    @if($errors->any())
        <p id="error" style="float:right;"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
    @endif
</header>
<form action="{{route('updatePurchase')}}" method="POST">
    @csrf
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="vendor-data-tab" data-toggle="tab" href="#vendor-data" role="tab" aria-controls="vendor-data" aria-selected="true">Vendor Data</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="accounting-tab" data-toggle="tab" href="#accounting" role="tab" aria-controls="accounting" aria-selected="false">Accounting</a>
  </li>
    <li class="nav-item">
    <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active p-3" id="vendor-data" role="tabpanel" aria-labelledby="vendor-data-tab">
        <div class="form-group row">
            <label for="po_number" class="col-form-label col-md-2">Purchase number</label>
            <input type="text" name="po_number" id="po_number" class="form-control col-md-2" readonly="true" value="{{ $purchase->po_number }}">
            <label for="currency" class="col-form-label col-md-2">Currency</label>
            <select name="currency" id="currency" class="form-control col-md-2 custom-select" disabled="true">
                @foreach($currencies as $currency)
                <option value="{{ $currency->currency }}" @if($purchase->currency==$currency->currency) selected="true" @endif>{{ $currency->currency}}</option>
                @endforeach
            </select> 
            <label for="payment_term" class="col-form-label col-md-2">Payment Term</label>
            <input type="text" name="payment_term" id="payment_term" class="form-control col-md-2" value="{{ $purchase->payment_term }}" readonly="true">
        </div>

        <div class="form-group row"> 
            <label for="delivery_date" class="col-form-label col-md-2">Delivery Date</label>
            <input type="text" name="delivery_date" id="delivery_date" class="form-control col-md-2" value="{{ $purchase->delivery_date }}" readonly="true">
            <label for="delivery_term" class="col-form-label col-md-2">Delivery Term</label>
            <select name="delivery_term" id="delivery_term" class="form-control col-md-1 custom-select" disabled="true">
                @foreach ($delivery_terms as $delivery_term)
                <option value="{{ $delivery_term->delivery_term }}" @if ($purchase->delivery_term == $delivery_term->delivery_term) selected="true" @endif>{{ $delivery_term->delivery_term }}</option>
                @endforeach
             </select>
            <input type="text" name="delivery_place" id="delivery_place" class="form-control col-md-3" value="{{ $purchase->delivery_place }}" readonly="true">
        </div>  
        <div class="form-group row">
            <label for="vendor_number" class="col-form-label col-md-2">Vendor Number</label>
            <div class="col-md-2 pl-0 pr-0">
                <div class="input-group">
                    <input type="text" name="vendor_number" id="vendor_number" class="form-control" value="{{ $purchase->vendor_number }}" readonly="true">
                    <div class="input-group-addon">
                        <span class="fa fa-search" id="find_vendor"></span>
                    </div>
                </div>
            </div>
            <label for="vendor_name" class="col-form-label col-md-2">Name (*)</label>
            <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6" readonly="true" value="{{ $purchase->vendor_name }}">
        </div>
        <div class="form-group row">
            <label for="country" class="col-form-label col-md-2">Country</label>
            <input type="text" name="country" id="country" class="form-control col-md-2" value="{{ $purchase->country_code }}" readonly="true">
            <label for="contact" class="col-form-label col-md-2">Contact person</label>
            <input type="text" name="contact" id="contact" class="form-control col-md-2" value="{{ $purchase->contact }}" readonly="true">
            <label for="email" class="col-form-label col-md-2">Email address</label>
            <input type="text" name="email" id="email" class="form-control col-md-2" value="{{ $purchase->email }}" readonly="true">
        </div>
    </div>
    
    <div class="tab-pane fade p-3" id="accounting" role="tabpanel" aria-labelledby="accounting-tab">
        <div class="form-group row">
            <label for="total_amount" class="col-form-label col-md-3">Total Amount</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control col-md-3" readonly="true">
        </div>    
        
        <div class="form-group row">
            <label for="total_import_duty" class="col-form-label col-md-3">Import Duty</label>
            <input type="text" name="total_import_duty" id="total_import_duty" class="form-control col-md-3" readonly="true">
        </div>
        
        <div class="form-group row">    
            <label for="total_freight_handling_cost" class="col-form-label col-md-3">Freight + Handling Cost</label>
            <input type="text" name="total_freight_handling_cost" id="total_freight_handling_cost" class="form-control col-md-3" value="{{ $purchase->total_freight_handling_cost }}" readonly="true">
        </div>

        <div class="form-group row">
            <label for="total_cost" class="col-form-label col-md-3">Total Cost</label>
            <input type="text" name="total_cost" id="total_cost" class="form-control col-md-3" readonly="true">
        </div>
    </div>

    <div class="tab-pane fade p-3" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
        <div class="form-group">
            <label for="shipping_instruction"><u>Shipping Instruction:</u></label>
            <textarea name="shipping_instruction" class="form-control" id="shipping_instruction" rows="7" readonly="true">{{$purchase->shipping_instruction }}</textarea>
        </div>
    </div>
  
</div>
<div class="p-3">
    <div class="form-group row">
        <label for="user_id" class="col-form-label col-md-2">Created by</label>
        <input type="text" name="user_id" id="user_id" class="form-control col-md-2" readonly="true" value="{{ $purchase->user_id }}">
    </div>  
    <table class="table table-bordered form-group">
        <thead>
            <tr>
                <th scope="col">Material Number</th>
                <th scope="col">Material Name</th>
                <th scope="col">Unit</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Import</th>
                <th scope="col">Freight + Handling</th>
            </tr>
        <thead>
        <tbody>
            @foreach($purchase_details as $p)
            <tr>
                <td>
                    <div class="input-group">
                        <input type="text" name="material_number[]" class="form-control material_number" value="{{ $p->material_number }}" readonly="true">
                        <div class="input-group-addon">
                            <span class="fa fa-search find_material"></span>
                        </div>
                    </div>
                </td>
                <td><input type="text" name="material_description[]" class="form-control material_description" readonly="true" value="{{ $p->material_description }}"></td>
                <td><input type="text" name="unit[]" class="form-control unit" readonly="true" value="{{ $p->unit }}"></td>
                <td><input type="text" name="quantity[]" class="form-control quantity" value="{{ $p->quantity }}" readonly="true">
                </td>
                <td><input type="text" name="unit_price[]" class="form-control unit_price" value="{{ $p->unit_price }}" readonly="true"></td>
                <td><input type="text" name="amount[]" class="form-control amount" readonly="true"></td>
                <td><input type="text" name="import_duty[]" class="form-control import_duty" value="{{ $p->import_duty }}" readonly="true"></td>
                <td><input type="text" name="freight_handling_cost[]" class="form-control freight_handling_cost" readonly="true" value="{{ $p->freight_handling_cost }}"></td>
            </tr>
            @endforeach

        </tbody>
    </table> 
 
    <button id="back" class="btn btn-cancel">Back</button>
    <button type="submit" id="edit" class="btn btn-save">Edit</button>
    <button id="save" class="btn btn-save" hidden="true">Save</button>
    <button id="delete" class="btn btn-cancel">Delete</button>
</div>
</form>



@endsection
@section('script')
<script type="text/javascript">
    searchMaterial();
    amount();
    totalAmount();
    importDuty();
    totalImportDuty();
    allocateFreight();
    totalCost();
    $('#delivery_date').datepicker({
        changeMonth:true,
        changeYear:true,
        dateFormat: "yy-mm-dd",
    })

    $('#find_vendor').on('click',function(){
        $('#vendor_form').modal('show');
    })

    $('#search_vendor').autocomplete({
        source: "{{route('searchVendor')}}",
        minLength:2,
        select:function(key,value){
            $('#vendor_number').val(value.item.id);
            $('#vendor_name').val(value.item.value);
        }
    })

    //=====================Link vendor information===========
    $('#vendor_number').on("change keyup",function(){
        var number = $('#vendor_number').val();
        var dataNumber = {'vendor_number': number};
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('findVendorInfo') !!}',
            datatype: 'json',
            data: dataNumber,
            success: function (vendor_info){
                $('#vendor_name').val(vendor_info.vendor_name);
                $('#country').val(vendor_info.country_code)
            },

       })
    })

    //=====Link material info====

    $('tbody').delegate('.material_number', 'change keyup',function(){
        var tr = $(this).closest('tr');
        var number = tr.find('.material_number').val();
        var dataNumber = {'material_number':number};
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('findMaterialInfo') !!}',
            datatype: 'json',
            data: dataNumber,
            success: function (material_info){
                tr.find('.material_description').val(material_info.material_description);
                tr.find('.unit').val(material_info.unit)
                }
            })
    })

    $('#vendor_number').on('change',function(){
        var number = $('#vendor_number').val();
        var dataNumber = {'vendor_number': number};
        $.ajax({
            type:'GET',
            url: "{{route('findVendorInfo')}}",
            datatype: 'json',
            data: dataNumber,
            success:function(vendor_info){
                $('#vendor_name').val(vendor_info.vendor_name);
            }
        })
    })


    // $('.find_material').on('click',function(){
    //     $('#material_form').modal('show');
    // })

    $(document).ready(function(){  

        $(document).on('click','.addRow',function(){
            var addRow ='<tr>'+
                        '<td>'+
                            '<div class="input-group">'+
                            '<input type="text" name="material_number[]" class="form-control material_number">'+
                            '<div class="input-group-addon">'+
                            '<span class="fa fa-search find_material"></span>'+
                            '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td><input type="text" name="material_description[]" class="form-control material_description" readonly="true"></td>'+
                        '<td><input type="text" name="unit[]" class="form-control unit" readonly="true"></td>'+
                        '<td><input type="text" name="quantity[]" class="form-control quantity"></td>'+
                        '<td><input type="text" name="unit_price[]" class="form-control unit_price"></td>'+
                        '<td><input type="text" name="amount[]" class="form-control amount" readonly="true"></td>'+
                        '<td><input type="text" name="import_duty[]" class="form-control import_duty" value=0></td>'+
                        '<td><input type="text" name="freight_handling_cost[]" class="form-control freight_handling_cost" readonly="true" value=0></td>'+
                        '<td><a href="#" class="removeRow">Remove</a></td>'+
                        '</tr>';
            $('tbody').append(addRow);
            searchMaterial();
            totalAmount();
            importDuty();
            totalImportDuty();
            allocateFreight();
            totalCost();
        })
    })

    $('tbody').on('click','.removeRow',function(){
        var l=$('tbody tr').length;
        if(l==1){
            alert('You can not remove last item.')
        }else{
            $(this).parents('tr').remove();
            totalAmount();
            totalImportDuty();
            allocateFreight();
            totalCost();
        }
    })

    function searchMaterial(){
        $('.find_material').on('click',function(){
            $('#material_form').modal('show');
            var tr = $(this).parents('tr');
            $('#search_material').autocomplete({
            source: "{!! URL::route('searchMaterial') !!}",
            minLength: 2,
            select:function(key,value){
                tr.find('.material_number').val(value.item.id);
                tr.find('.material_description').val(value.item.value);
                tr.find('.unit').val(value.item.unit);
            }
            })  
        })
    }

    $('tbody').delegate('.quantity, .unit_price','change keyup',function(){
            amount();
            totalAmount();
            totalImportDuty();
            allocateFreight();
            totalCost();
    }) 

    function amount(){
        var amount = 0;
        $('.amount').each(function(i,e){
            var tr = $(this).parents('tr');
            var quantity = tr.find('.quantity').val();
            var unit_price = tr.find('.unit_price').val();
            var amount = (quantity * unit_price);
            tr.find('.amount').val(amount.toFixed(2));
        })   
    }

//==============total Amount=====
    function totalAmount(){
        var total = 0;
        $('.amount').each(function(i,e){
            var amount = $(this).val()-0;
            total += amount; 
        })
        $('#total_amount').val(total);
    }

//====Import duty change=====================
    function importDuty(){
        $('.import_duty').on('change keyup',function(){
            totalImportDuty();
        });
    }

    //============calculate total import duty=============

    function totalImportDuty(){
        var totalImport = 0;
        $('.import_duty').each(function(i,e){
            var tr = $(this).parents('tr');
            var quantity = tr.find('.quantity').val();
            var importDuty = ($(this).val() * quantity)-0;
            totalImport += importDuty; 
        })
        $('#total_import_duty').val(totalImport);
    }

    //===============allocate freight handling cost=============
    function allocateFreight(){
        var freight = 0;
        var totalFreight = $('#total_freight_handling_cost').val();
        var totalAmount = $('#total_amount').val();
        var unit_freight = (totalFreight/totalAmount);
        $('.freight_handling_cost').each(function(i,e){
            var tr = $(this).parents('tr');
            var amount = tr.find('.amount').val();
            var quantity = tr.find('.quantity').val();
            var freight = (amount * unit_freight)/quantity;
            $(this).val(freight.toFixed(2));
        })

    }

    $('#total_freight_handling_cost').on('change',function(){
        allocateFreight();
        totalCost();

    })

    //=========Total cost============================================
    function totalCost(){
        var totalCost = 0;
        var totalAmount = $('#total_amount').val();
        var totalImport = $('#total_import_duty').val();
        var totalFreight = $('#total_freight_handling_cost').val();
        totalCost = (parseFloat(totalAmount) + parseFloat(totalImport) + parseFloat(totalFreight))-0;
        $('#total_cost').val(totalCost.toFixed(2));
    }

    //===============number and dot=============
    function number(input){
        $(input).keypress(function(evt){
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[-\d\.]/;
            var objRegex= /^-?\d*[\.]?\d*$/;
            var val = $(evt.target).val();
            if(!regex.test(key) || !objRegex.test(val+key)|| !theEvent.keyCode ==46 || !theEvent.keyCode == 8){
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            };
        })
    }
    //=============number only===================
    function numberOnly(input){
        $(input).keypress(function(evt){
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if(charCode > 31 && (charCode< 48 || charCode>57))
                return false;
            return true;
        })
    }

    //============find element by row-------===========
    function findRowNum(input)
    {
        $('tbody').delegate(input,'keydown',function(){
            var tr = $(this).parent().parent();
            number(tr.find(input));
        })
    }

    function findRowNumOnly(input)
    {
        $('tbody').delegate(input,'keydown',function(){
            var tr = $(this).parent().parent();
            numberOnly(tr.find(input));
        })
    }

    //==========call function number===========
    findRowNum('.quantity');
    findRowNum('.unit_price');
    findRowNum('.import_duty');
    number('#total_freight_handling_cost');
    findRowNumOnly('.material_number');
    //=============Click cancel=========
    $('#cancel').on('click',function(e){
        e.preventDefault();
        $(location).attr('href',"{{route('purchaseIndex')}}");
    })


//============================================


    $('#edit').on('click',function(e){
        e.preventDefault();
        $(this).attr('hidden',true);
        $('#save').attr('hidden',false);
        $('#print').attr('hidden',true);
        $('input').attr('readonly',false);
        $('select').attr('disabled',false);
        $('textarea').attr('readonly',false);
        $('#po_number').attr('readonly',true);
        $('#user_id').attr('readonly',true);
        $('#vendor_name').attr('readonly',true);
        $('.material_description').attr('readonly',true);
        $('.unit').attr('readonly',true);
        $('.amount').attr('readonly',true);
        $('.freight_handling_cost').attr('readonly',true);
        $('#total_amount').attr('readonly',true);
        $('#total_import_duty').attr('readonly',true);
        $('#total_cost').attr('readonly',true);
        $('#country').attr('readonly',true);
        $('thead tr').append('<th><a href="#" class="addRow">Add</a></th>');
        $('tbody tr').append('<td><a href="#" class="removeRow">Remove</a></td>');      
        disableRow();
    })

    $('#delete').on('click',function(e){
        e.preventDefault();
        po_number = po_number.value;
        $.post("{{ route('deletePurchase') }}",{po_number:po_number},function(data){
            $(location).attr('href',"{{ route('purchaseIndex')}}");
        })

    })

$('#back').on('click',function(e){
    e.preventDefault();
    $(location).attr('href',"{{route('purchaseIndex')}}");
})
//====error
    $('#error').on('click',function(){
            $('#error_box').modal('show')
    });
</script>


@endsection
