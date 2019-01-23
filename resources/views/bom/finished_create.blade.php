@extends('layout.main')
@include('layout.navhome')
@section('content')
@include('popup.search_semi')
@include('popup.error')
<style type="text/css">
    .quantity_raw, .moving_price, .amount, .total_amount{
        text-align: right;
    }

</style>
<div>
    <h3 class="pt-3">Finished Goods</h3>
    @if($errors->any())
    <p id="error" style="float:right;"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
    @endif
</div>
<form class="pt-3 pr-3 pb-3" action="{{route('createFinished')}}" method="POST">
    @csrf
<div>
        <div class="form-group row">
            <label for="finished_number" class="col-form-label col-md-2">Number</label>
            <input type="text" name="finished_number" id="finished_number" class="form-control col-md-2" readonly="true">
            <label for="finished_description" class="col-form-label col-md-2">Description</label>
            <input type="text" name="finished_description" id="finished_description" class="form-control col-md-6">
        </div>
    <div class="form-group row">
        <label for="created_by" class="col-form-label col-md-2">Created by</label>
        <input type="text" name="created_by" id="created_by" class="form-control col-md-2" readonly="true" value="{{ Auth::user()->id }}">
    </div>  
</div>
    <table class="table table-responsive-md table-bordered form-group">
        <thead>
            <tr>
                <th scope="col">Semi Number</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Remark</th>
                <th scope="col"><a href="#" class="addRow">Add</a></th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <td>
                    <div class="input-group">
                    <input type="text" name="semi_number[]" class="form-control semi_number">
                    <div class="input-group-addon">
                        <span class="fa fa-search find_semi"></span>
                    </div>
                    </div>
                </td>
                <td><input type="text" name="semi_description[]" class="form-control semi_description" readonly="true"></td>
                <td><input type="text" name="semi_quantity[]" class="form-control quantity_semi"></td>
                <td><input type="text" name="remark[]" class="form-control remark"></td>
                <td><a href="#" class="removeRow">Remove</a></td>
            </tr>

        </tbody>
    </table> 
    <button type="submit" class="btn btn-save">Save</button>
    <button id="cancel" class="btn btn-cancel">Cancel</button>
</div> 
</form>

@endsection
@section('script')
<script type="text/javascript">

searchSemi();

    function searchSemi(){
        $('.find_semi').on('click',function(){
            $('#semi_form').modal('show');
            var tr=$(this).parents('tr');
            $('#search_semi').autocomplete({
                source: "{{ URL::route('searchSemi')}}",
                minLength: 1,
                select:function(key,value){
                    tr.find('.semi_number').val(value.item.id);
                    tr.find('.semi_description').val(value.item.value);
                }
            })
        })
    }

    $('tbody').on('change','.semi_number',function(){
        var tr = $(this).closest('tr');
        var number = tr.find('.semi_number').val();
        var dataNumber = {'semi_number':number};
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('findSemiInfo') !!}',
            datatype: 'json',
            data: dataNumber,
            success: function(semi_info){
                tr.find('.semi_description').val(semi_info.semi_description);
            }
        })
    });

$(document).ready(function(){  

    $(document).on('click','.addRow',function(){
        var addRow ='<tr>'+
                    '<td>'+
                    '<div class="input-group">'+
                        '<input type="text" name="semi_number[]" class="form-control semi_number">'+
                        '<div class="input-group-addon">'+
                        '<span class="fa fa-search find_semi"></span>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
                '<td><input type="text" name="semi_description[]" class="form-control semi_description" readonly="true"></td>'+
                '<td><input type="text" name="semi_quantity[]" class="form-control quantity_semi"></td>'+
                '<td><input type="text" name="remark[]" class="form-control remark"></td>'+
                '<td><a href="#" class="removeRow">Remove</a></td>'+
                    '</tr>';
        $('tbody').append(addRow);
        searchSemi();
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

$('#cancel').on('click',function(e){
    e.preventDefault();
    $(location).attr('href',"{{route('bomPage')}}");
})

$('#error').on('click',function(){
    $('#error_box').modal('show')
});
</script>

@endsection
