@extends('layout.main')

@section('content') 
            <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Inbound</h5>
                  </div>
                  <div class="card-body">
                <form class="pb-3 pr-3" action="{{route('createInbound')}}" method="POST">
                    @csrf  
                    <div class="form-group row">
                        <label for="po_number" class="col-form-label col-md-2">Purchase number</label>
                        <input type="text" name="po_number" id="po_number" class="form-control col-md-2" value={{ $purchase->po_number }}>
                    </div>                    
                    <div class="form-group row">
                        <input type="text" name="po_number" id="po_number" class="form-control col-md-2" value="{{ $purchase->po_number}}" hidden="true">
                        <label for="vendor_name" class="col-form-label col-md-2">Vendor Name</label>
                        <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6" value="{{ $purchase->vendor_name }}" readonly="true">     
                        <label for="receipt_date" class="col-form-label col-md-2">Receipt Date</label>
                        <input type="text" name="receipt_date" id="receipt_date" class="form-control col-md-2" value="{{old('receipt_date')? old('receipt_date') : $purchase->delivery_date}}">    
                    </div>
                    <table class="table table-responsive-md table-bordered form-group">
                        <thead>
                        <tr>
                            <th scope="col">Material Number</th>
                            <th scope="col">Material Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Ordered Quantity</th>
                            <th scope="col">Past Receipt Qty</th>
                            <th scope="col">Receipt Qty </th>
                            <th scope="col">Pending Quantity</th>
                            <th></th>
                        </tr>
                        </thead>
                        @if(old('material_number'))
                            <tbody>
                                @foreach(old('material_number') as $key=>$value)
                                        <tr>
                                            <td><input type="text" name="material_number[]" class="form-control material_number" value="{{$value}}" readonly="true">
                                            <input type="text" name="pod_num[]" class="form-control pod_num" value="{{old('pod_num')[$key]}}" readonly="true" hidden="true">
                                            </td>
                                            <td><input type="text" name="material_description[]" class="form-control material_description" value="{{old('material_description')[$key]}}" readonly="true"></td>
                                            <td><input type="text" name="unit[]" class="form-control unit" value="{{old('unit')[$key]}}" readonly="true"></td>
                                            <td>
                                                <input type="text" name="ordered_quantity[]" class="form-control ordered_quantity" value="{{old('ordered_quantity')[$key]}}" readonly="true" style="text-align: right;">
                                            </td>
                                            <td>
                                                <input type="text" name="past_receipt_quantity[]" class="form-control past_receipt_quantity" value="{{old('past_receipt_quantity')[$key]}}" readonly="true" style="text-align: right;"> 
                                            </td>
                                            <td><input type="text" name="total_receipt_quantity_per_row[]" class="form-control total_receipt_quantity_per_row" style="text-align: right;" readonly="true" value="{{old('total_receipt_quantity_per_row')[$key]}}"></td>
                                            <td><input type="text" name="total_pending_quantity_per_row[]" class="form-control total_pending_quantity_per_row" style="text-align: right;" readonly="true" value="{{old('total_pending_quantity_per_row')[$key]}}"></td>
                                            <td><a href="#" class="accordion-toggle @if(old('past_receipt_quantity')[$key] == old('ordered_quantity')[$key]) d-none @endif" data-toggle="collapse" data-target="#_{{old('pod_num')[$key]}}">Detail</a></td>
                                        </tr>

                                        <tr>
                                            <td colspan="7">
                                                <div class="accordion-body collapse" id="_{{old('pod_num')[$key]}}">
                                                    @foreach(old('pod_number') as $k=>$v)
                                                        @if($v == old('pod_num')[$key])
                                                            <div class="form-group row">
                                                                <input type="text" name="pod_number[]" class="form-control pod_number" value="{{$v}}" readonly="true" hidden="0">                                                        
                                                                <label for="receipt_quantity" class="col-form-label col-md-2">Receipt quantity</label>
                                                                <input type="text" class="form-control col-md-2 receipt_quantity" name="receipt_quantity[]" value="{{old('receipt_quantity')[$k]}}">                                                        
                                                                <label for="batch_number" class="col-form-label col-md-2">Batch number</label>
                                                                <input type="text" name="batch_number[]" class="form-control col-md-2 batch_number" value="{{old('batch_number')[$k]}}">
                                                                <a href="#" class="add_more_batch">Add more batch</a>
                                                            </div>   
                                                        @endif
                                                    @endforeach                      
                                                </div>                                             
                                            </td>
                                        </tr>                                        
                                    @endforeach
                                </tbody>
                            @else
                                @foreach ($purchase_details as $pur)
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="material_number[]" class="form-control material_number" value="{{$pur->material_number}}" readonly="true">
                                            <input type="text" name="pod_num[]" class="form-control pod_num" value="{{$pur->number}}" readonly="true" hidden="true">                                                        
                                            </td>
                                            <td><input type="text" name="material_description[]" class="form-control material_description" value="{{$pur->material_description}}" readonly="true"></td>
                                            <td><input type="text" name="unit[]" class="form-control unit" value="{{$pur->unit}}" readonly="true"></td>
                                            <td>
                                                <input type="text" name="ordered_quantity[]" class="form-control ordered_quantity" value="{{$pur->quantity}}" readonly="true" style="text-align: right;">
                                            </td>
                                            <td>
                                                <input type="text" name="past_receipt_quantity[]" class="form-control past_receipt_quantity" value="{{$pur->past_receipt_quantity}}" readonly="true" style="text-align: right;"> 
                                            </td>
                                            <td><input type="text" name="total_receipt_quantity_per_row[]" class="form-control total_receipt_quantity_per_row" style="text-align: right;" readonly="true"></td>
                                            <td><input type="text" name="total_pending_quantity_per_row[]" class="form-control total_pending_quantity_per_row" style="text-align: right;" readonly="true"></td>
                                            <td><a href="#" class="accordion-toggle @if($pur->past_receipt_quantity == $pur->quantity) d-none @endif" data-toggle="collapse" data-target="#_{{$pur->number}}">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <div class="accordion-body collapse" id="_{{$pur->number}}">
                                                    <div class="form-group row">
                                                        <input type="text" name="pod_number[]" class="form-control pod_number" value="{{$pur->number}}" readonly="true" hidden="true">                                                        
                                                        <label for="receipt_quantity" class="col-form-label col-md-2">Receipt quantity</label>
                                                        <input type="text" class="form-control col-md-2 receipt_quantity" name="receipt_quantity[]">                                                        
                                                        <label for="batch_number" class="col-form-label col-md-2">Batch number</label>
                                                        <input type="text" name="batch_number[]" class="form-control col-md-2 batch_number">
                                                        <a href="#" class="add_more_batch">Add more batch</a>
                                                    </div>                         
                                                </div>                                             
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                            
                            @endif
                            <tfoot>

                            <tr>
                                <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                                <td><input type="text" name="total_quantity" class="form-control total_quantity" style="text-align: right; font-weight: bold;" readonly="true"></td>
                                <td><input type="text" name="total_past_receipt_quantity" class="form-control total_past_receipt_quantity" style="text-align: right; font-weight: bold;" readonly="true" value="{{old('total_past_receipt_quantity')}}"></td>
                                <td><input type="text" name="total_receipt_quantity" class="form-control total_receipt_quantity" style="text-align: right; font-weight: bold;" readonly="true" value="{{old('total_receipt_quantity')}}"></td>
                                <td><input type="text" name="total_pending_quantity" class="form-control total_pending_quantity" style="text-align: right; font-weight: bold;" readonly="true"></td>
                                <td></td>
                            </tr>
                            </tfoot>
                    </table>        
                    <button id="save" type="submit" class="btn btn-primary">Save</button>
                    <button id="cancel" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">

total_quantity();
checkReceiptQuantity();
total_past_receipt_quantity();

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

$('.add_more_batch').on('click',function(){
    var td = $(this).closest('td');
    var pod_number = td.find('.pod_number').val();
    var row = td.find('.accordion-body');
    row.append(`<div class="form-group row">
        <input type="text" name="pod_number[]" class="form-control" value="${pod_number}" readonly="true">
        <label for="receipt_quantity" class="col-form-label col-md-2">Receipt quantity</label>
        <input type="text" class="form-control col-md-2 receipt_quantity" name="receipt_quantity[]">
        <label for="batch_number" class="col-form-label col-md-2">Batch number</label>
        <input type="text" name="batch_number[]" class="form-control col-md-2 batch_number">
        </div>`  
    )
})


 $('tbody').on('change','.receipt_quantity',function(){
    var tr = $(this).parents('tr');
    var tbody = tr.parents('tbody');
    var total_receipt_quantity_per_row = 0;
    tr.find('.receipt_quantity').each(function(i,e){
        var receipt_quantity = $(this).val()-0;
        total_receipt_quantity_per_row += receipt_quantity;
    })
    tbody.find('.total_receipt_quantity_per_row').val(total_receipt_quantity_per_row);
    var ordered_quantity_per_row = tbody.find('.ordered_quantity').val();
    var past_receipt_quantity = tbody.find('.past_receipt_quantity').val()
    var total_pending_quantity_per_row = ordered_quantity_per_row - total_receipt_quantity_per_row - past_receipt_quantity;
    tbody.find('.total_pending_quantity_per_row').val(total_pending_quantity_per_row);
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

function total_past_receipt_quantity(){
    var total_past_receipt_quantity = 0;
    $('.past_receipt_quantity').each(function(i,e){
        var past_receipt_quantity = $(this).val()-0;
        total_past_receipt_quantity += past_receipt_quantity;
    })
    $('.total_past_receipt_quantity').val(total_past_receipt_quantity);
}

function total_receipt()
{
    var total_received = 0;
    $('.total_receipt_quantity_per_row').each(function(i,e){
        var receipt_qty = $(this).val()-0;
        total_received += receipt_qty;
    })
    $('.total_receipt_quantity').val(total_received);
}


function total_pending()
{
    var total_pend = 0;
    $('.total_pending_quantity_per_row').each(function(i,e){
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