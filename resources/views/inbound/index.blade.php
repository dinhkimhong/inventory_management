@extends('layout.main')
@include('layout.navhome')

@section('content') 
<h3 class="pt-3">Inbound</h3>
<form action="{{route('inboundPage')}}" method="GET">
    <div class="form-group row">
        <label for="po_number" class="col-form-label col-md-2">Purchase number</label>
        <input type="text" name="po_number" id="po_number" class="form-control col-md-2">
        <button class="btn btn-save">Go</button>
    </div>
</form>
<form class="pb-3 pr-3">
    <div class="form-group row">
        <label for="inbound_number" class="col-form-label col-md-2">Inbound number</label>
        <input type="text" name="inbound_number" id="inbound_number" class="form-control col-md-2" readonly="true">
    </div>    
    <div class="form-group row">
        <label for="vendor_name" class="col-form-label col-md-2">Vendor Name</label>
        <input type="text" name="vendor_name" id="vendor_name" class="form-control col-md-6" readonly="true">     
        <label for="receipt_date" class="col-form-label col-md-2">Receipt Date</label>
        <input type="text" name="receipt_date" id="receipt_date" class="form-control col-md-2">    
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
            <tr>
            <td><input type="text" name="material_number[]" class="form-control material_number" readonly="true"></td>
            <td><input type="text" name="material_description[]" class="form-control material_description" readonly="true"></td>
            <td><input type="text" name="unit[]" class="form-control unit" readonly="true"></td>
            <td><input type="text" name="ordered_quantity[]" class="form-control quantity" readonly="true"></td>
            <td><input type="text" name="receipt_quantity" class="form-control receipt_quantity"></td>
            <td><input type="text" name="batch_number" class="form-control batch_number"></td>
            <td><input type="text" name="pending_quantity" class="form-control pending_quantity"></td>
            <td><a href="#" class="removeRow">Remove</a></td>
        </tr>
        </tbody>
    </table>        
</form>
@endsection