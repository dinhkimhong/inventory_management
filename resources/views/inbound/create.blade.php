@extends('layout.main')
@include('layout.navhome')
@include('popup.error')

@section('content') 
<div>
    <h3 class="pt-3">Inbound</h3>
    @if($errors->any())
        <p id="error" style="float:right;"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
    @endif
</div>
<form action="{{route('inboundPage')}}" method="GET">
    <div class="form-group row">
        <label for="po_number" class="col-form-label col-md-2">Purchase number</label>
        <input type="text" name="po_number" id="po_number" class="form-control col-md-2" value={{ $purchase->po_number }}>
        <button id="back" class="btn btn-save">Go</button>
    </div>
</form>
<form class="pb-3 pr-3" action="{{route('createInbound')}}" method="POST">
    @csrf
    <div class="form-group row">
        <label for="inbound_number" class="col-form-label col-md-2">Inbound number</label>
        <input type="text" name="inbound_number" id="inbound_number" class="form-control col-md-2" readonly="true">
        <input type="text" name="po_number" id="po_number" class="form-control col-md-2" value="{{ $purchase->po_number}}" hidden="true">
    </div>    
    <div class="form-group row">
        <label for="vendor_name" class="col-form-label col-md-2">Vendor Name</label>
        <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6" value="{{ $purchase->vendor_name }}" readonly="true">     
        <label for="receipt_date" class="col-form-label col-md-2">Receipt Date</label>
        <input type="text" name="receipt_date" id="receipt_date" class="form-control col-md-2" value="{{ date('Y-m-d')}}">    
    </div>
    <table class="table table-responsive-md table-bordered form-group">
        <thead>
        <tr>
            <th scope="col">Material Number</th>
            <th scope="col">Material Name</th>
            <th scope="col">Unit</th>
            <th scope="col">Ordered Quantity</th>
            <th scope="col">Receipt Quantity </th>
            <th scope="col">Batch number </th>
            <th scope="col">Pending Quantity</th>
            <th></th>
        </tr>
        <thead>
        <tbody>
            @foreach ($purchase_details as $pur)
            <tr>
                <td><input type="text" name="material_number[]" class="form-control material_number" value="{{$pur->material_number}}" readonly="true">
<!--                     <input type="text" name="po_number[]" class="form-control" value="{{$pur->po_number}}" readonly="true" hidden="true"> -->
                </td>
                <td><input type="text" name="material_description[]" class="form-control material_description" value="{{$pur->material_description}}" readonly="true"></td>
                <td><input type="text" name="unit[]" class="form-control unit" value="{{$pur->unit}}" readonly="true"></td>
                <td>
                    <input type="text" name="ordered_quantity[]" class="form-control ordered_quantity" value="{{$pur->quantity}}" readonly="true" style="text-align: right;">
                    <input type="text" name="unit_price[]" class="form-control" value="{{$pur->unit_price}}" readonly="true" style="text-align: right;" hidden="true"> 
                    <input type="text" name="import_duty[]" class="form-control" value="{{$pur->import_duty}}" readonly="true" style="text-align: right;" hidden="true"> 
                    <input type="text" name="freight_handling_cost[]" class="form-control" value="{{$pur->freight_handling_cost}}" readonly="true" style="text-align: right;" hidden="true"> 
                    <input type="text" name="past_receipt_quantity[]" class="form-control past_receipt_quantity" value="{{$pur->past_receipt_quantity}}" readonly="true" style="text-align: right;" hidden="true"> 
                </td>
                <td><input type="text" name="receipt_quantity[]" class="form-control receipt_quantity" style="text-align: right;"></td>
                <td><input type="text" name="batch_number[]" class="form-control batch_number"></td>
                <td><input type="text" name="pending_quantity[]" class="form-control pending_quantity" style="text-align: right;" readonly="true"></td>
                <td><a href="#" class="removeRow">Remove</a></td>
            </tr>
            @endforeach
            <tfoot>
            <tr>
                <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                <td><input type="text" name="total_quantity" class="form-control total_quantity" style="text-align: right; font-weight: bold;" readonly="true"></td>
                <td><input type="text" name="total_receipt_quantity" class="form-control total_receipt_quantity" style="text-align: right; font-weight: bold;" readonly="true"></td>
                <td></td>
                <td><input type="text" name="total_pending_quantity" class="form-control total_pending_quantity" style="text-align: right; font-weight: bold;" readonly="true"></td>
                <td></td>
            </tr>
            </tfoot>
        </tbody>
    </table>        
    <button id="save" type="submit" class="btn btn-save">Save</button>
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</form>
@endsection
@section('script')
<script type="text/javascript">

total_quantity();
checkReceiptQuantity();

$('tbody').on('click','.removeRow',function(){
        var l=$('tbody tr').length;
        if(l==1){
            alert('You can not remove last item.')
        }else{
            $(this).parents('tr').remove();
        }
    total_quantity();
    total_receipt();
    total_pending();
})

$('.receipt_quantity').on('change keyup',function(){
    var tr = $(this).parents('tr');
    var receipt_quantity = tr.find('.receipt_quantity').val();
    var past_receipt_quantity = tr.find('.past_receipt_quantity').val();
    var ordered_quantity = tr.find('.ordered_quantity').val()
    if(past_receipt_quantity != 0){
        var pending_quantity = (ordered_quantity - past_receipt_quantity - receipt_quantity);
    }else{
        var pending_quantity = (ordered_quantity - receipt_quantity);
    }
    tr.find('.pending_quantity').val(pending_quantity);
    total_receipt();
    total_pending();
})


function total_quantity()
{
    var total_ordered = 0;
    $('.ordered_quantity').each(function(i,e){
        var ordered_qty = $(this).val()-0;
        total_ordered += ordered_qty;
    })
    $('.total_quantity').val(total_ordered);
}

function total_receipt()
{
    var total_received = 0;
    $('.receipt_quantity').each(function(i,e){
        var receipt_qty = $(this).val()-0;
        total_received += receipt_qty;
    })
    $('.total_receipt_quantity').val(total_received);
}


function total_pending()
{
    var total_pend = 0;
    $('.pending_quantity').each(function(i,e){
        var pending_qty = $(this).val()-0;
        total_pend += pending_qty;
    })
    $('.total_pending_quantity').val(total_pend);
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

//============find element by row-------===========
function findRowNum(input)
{
    $('tbody').delegate(input,'keydown',function(){
        var tr = $(this).parent().parent();
        number(tr.find(input));
    })
}

findRowNum('.receipt_quantity');


//============function check receipt_quantity valid==============

function checkReceiptQuantity(){
    $('.past_receipt_quantity').each(function(i,e){
        var tr = $(this).parents('tr');
        var ordered_quantity = tr.find('.ordered_quantity').val();
        var past_receipt_quantity = tr.find('.past_receipt_quantity').val();
        if(past_receipt_quantity == ordered_quantity){
            tr.find('.receipt_quantity').attr('readonly',true);
            tr.find('input').attr('name','');
        }
    })
}
//===============click Save===========

$('#save').on('click',function(event){
    $('.material_number').each(function(i,e){
        var tr = $(this).parents();
        var pending_quantity = tr.find('.pending_quantity').val();
        if(pending_quantity < 0){
            event.preventDefault();
            $('#back').click();
            //event.preventDefault();
            // $('.print-msg-error').empty();
            // $('.print-msg-error').css('display','block');
            // $('.print-msg-success').css('display','none');
            $('.print-msg-error').append(
                '<div class="alert alert-warning" role="alert">'+
                'Received goods can not be more than purchase order'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
                '</button>'+
                '</div>'
            );
        }
    })
})

$('#cancel').on('click',function(e){
    e.preventDefault();
    $(location).attr('href',"{{route('inboundIndex')}}");
})



//====error
$('#error').on('click',function(){
            $('#error_box').modal('show')
});

</script>




@endsection()