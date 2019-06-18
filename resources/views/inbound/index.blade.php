@extends('layout.main')

@section('content') 
            <div class="col-md-12">
                <div class="card p-3">
                  <div class="card-header">
                    <h5 class="title">Inbound</h5>
                  </div>
                  <div class="card-body">
                <form action="{{route('inboundPage')}}" method="GET">
                    <div class="form-group row">
                        <label for="po_number" class="col-form-label col-md-2">Purchase number</label>
                        <input type="text" name="po_number" id="po_number" class="form-control col-md-2">
                        <button class="btn btn-primary my-auto">Go</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection