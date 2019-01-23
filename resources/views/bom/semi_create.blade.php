@extends('layout.main')
@include('layout.navhome')
@section('content')
@include('popup.search_material')
@include('popup.error')
<style type="text/css">
    .quantity_raw, .moving_price, .amount, .total_amount{
        text-align: right;
    }

</style>
<div>
    <h3 class="pt-3">Semifinished Goods</h3>
    @if($errors->any())
    <p id="error" style="float:right;"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
    @endif
</div>
<form class="pt-3 pr-3 pb-3" action="{{route('createSemi')}}" method="POST">
    @csrf
<div>
    <div class="form-group row">
            <label for="semi_number" class="col-form-label col-md-2">Semi Number</label>
            <input type="text" name="semi_number" id="semi_number" class="form-control col-md-2" readonly="true">
            <label for="semi_description" class="col-form-label col-md-2">Description</label>
            <input type="text" name="semi_description" id="semi_description" class="form-control col-md-6">
        </div>
    <div class="form-group row">
        <label for="created_by" class="col-form-label col-md-2">Created by</label>
        <input type="text" name="created_by" id="created_by" class="form-control col-md-2" readonly="true" value="{{ Auth::user()->id }}">
    </div>  
</div>
    <table class="table table-responsive-md table-bordered form-group">
        <thead>
            <tr>
                <th scope="col">Material Number</th>
                <th scope="col">Material Name</th>
                <th scope="col">Unit</th>
                <th scope="col">Quantity</th>
                <th scope="col">Moving Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Remark</th>
                <th scope="col"><a href="#" class="addRow">Add</a></th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td>
                    <div class="input-group">
                    <input type="text" name="material_number[]" class="form-control material_number">
                    <div class="input-group-addon">
                        <span class="fa fa-search find_material"></span>
                    </div>
                    </div>
                </div>

                </td>
                <td><input type="text" name="material_description[]" class="form-control material_description" readonly="true"></td>
                <td><input type="text" name="unit[]" class="form-control unit" readonly="true"></td>
                <td><input type="text" name="quantity_raw[]" class="form-control quantity_raw"></td>
                <td><input type="text" name="moving_price[]" class="form-control moving_price" readonly="true"></td>
                <td><input type="text" name="amount[]" class="form-control amount" readonly="true"></td>
                <td><input type="text" name="remark[]" class="form-control remark"></td>
                <td><a href="#" class="removeRow">Remove</a></td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="font-weight: bold; text-align: center;">Total Amount</td>
                <td><input type="text" name="total_amount" class="form-control total_amount" readonly="true"></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table> 
    <button type="submit" class="btn btn-save">Save</button>
    <!-- <a href="" class="btn btn-cancel" style="color: #333;">Cancel</a> -->
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</div> 
</form>

@endsection
@section('script')
<script type="text/javascript">
searchMaterial();
amount();
totalAmount();

function searchMaterial(){
    $('.find_material').on('click',function(){
        $('#material_form').modal('show');
        var tr = $(this).parents('tr');
        $('#search_material').autocomplete({
        source: "{!! URL::route('searchMaterial') !!}",
        minLength: 1,
        select:function(key,value){
            tr.find('.material_number').val(value.item.id);
            tr.find('.material_description').val(value.item.value);
            tr.find('.unit').val(value.item.unit);
            tr.find('.moving_price').val(value.item.moving_price);
        }
        })  
    })
}

$('tbody').delegate('.material_number','change keyup',function(){
        var tr = $(this).parents('tr');
        var number = tr.find('.material_number').val();
        var dataNumber = {'material_number':number};
        $.ajax({
            type:'GET',
            url:'{{URL::route('findMaterialInfo') }}',
            datatype: 'json',
            data: dataNumber,
            success: function(material_info){
                tr.find('.material_description').val(material_info.material_description);
                tr.find('.unit').val(material_info.unit);
                tr.find('.moving_price').val(material_info.moving_price);
            }
        })

})


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
                    '<td><input type="text" name="quantity_raw[]" class="form-control quantity_raw"></td>'+
                    '<td><input type="text" name="moving_price[]" class="form-control moving_price" readonly="true"></td>'+
                    '<td><input type="text" name="amount[]" class="form-control amount" readonly="true"></td>'+
                    '<td><input type="text" name="remark[]" class="form-control remark"></td>'+
                    '<td><a href="#" class="removeRow">Remove</a></td>'+
                    '</tr>';
        $('tbody').append(addRow);
        searchMaterial();
    })

    $('tbody').on('click','.removeRow',function(){
        var l=$('tbody tr').length;
        if(l==1){
            alert('You can not remove last item.')
        }else{
            $(this).parents('tr').remove();
        }
        totalAmount();
    })

});

$('tbody').on('change keyup','.quantity_raw',function(){
        amount();
        totalAmount();
})
  
function amount(){
        var amount = 0;
        $('.amount').each(function(i,e){
            var tr = $(this).parents('tr');
            var quantity = tr.find('.quantity_raw').val();
            var moving_price = tr.find('.moving_price').val();
            var amount = quantity*moving_price;
            tr.find('.amount').val(amount.toFixed(2));
        })
}

function totalAmount(){
        var total_amount = 0;
        $('.material_number').each(function(i,e){
            var tr = $(this).parents('tr');
            var amount = tr.find('.amount').val();
            total_amount += parseFloat(amount);
            
        })
        $('tfoot').find('.total_amount').val(total_amount.toFixed(2));
}

$('#cancel').on('click',function(e){
    e.preventDefault();
    $(location).attr('href',"{{route('inboundIndex')}}");
})

$('#error').on('click',function(){
    $('#error_box').modal('show')
});
</script>

@endsection
