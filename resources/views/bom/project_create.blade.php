@extends('layout.main')
@include('layout.navhome')
@section('content')
@include('popup.search_finished')
@include('popup.error')
<div>
	<h3 class="pt-3">Project</h3>
	@if($errors->any())
    <p id="error" style="float:right;"><a href="#" style="color: red;" class="blinking">(*) Error</a></p>
    @endif
</div>
<div class="pb-3">
	<section class="panel panel-default pb-3" style="border-bottom: 1px solid #cccccc;">
		<div class="panel-body">
			<form action="{{ route('createProject')}} " method="POST">
				@csrf
				<div class="form-group pb-3" style="border-bottom: 1px solid #cccccc;">
					<div class="row">
			            <label for="project_number" class="col-form-label col-md-2">Project Number</label>
			            <input type="text" name="project_number" id="project_number" class="form-control col-md-2" value="{{ $project_number }}" readonly="true">	
			            <label for="total_value" class="col-form-label col-md-2">Total Value (CAD)</label>
			            <input type="text" id="total_value" class="form-control col-md-2" readonly="true" style="text-align: right;">
			        </div>
			    </div>
				<div class="form-row">
					<div class="form-group col-md-2">
			            <label for="finished_number" class="col-form-label">Finished Goods Number</label>
			            <div class="input-group">
			            <input type="text" name="finished_number" id="finished_number" class="form-control">
			            <div class="input-group-addon">
			            	<span class="fa fa-search" id="find_finished"></span>
			            </div>
			        	</div>
		        	</div>
		        	<div class="form-group col-md-6">
			            <label for="finished_description" class="col-form-label">Description</label>
			            <input type="text" name="finished_description" id="finished_description" class="form-control" readonly="true">
			        </div>
			        <div class="form-group col-md-2">
			           	<label for="quantity_finished" class="col-form-label">Quantity</label>
			            <input type="text" name="finished_quantity" id="quantity_finished" class="form-control">
			        </div>
			        <div class="form-group col-md-2">
			           	<label for="remark" class="col-form-label">Remark</label>
			            <input type="text" name="remark" id="remark" class="form-control">
			        </div>
			    </div>
			    <button type="submit" class="btn btn-save">Add</button>
			</form>
		</div>
	</section>

	<section class="panel panel-default">
		<header class="panel-heading">Details</header>
		<div class="panel-body table-responsive">
			<table class="table table-responsive-md table-hover table-condensed table-bordered" id="project-table">
				<thead>
					<tr>
						<th>F.Item</th>
						<th>F.Quantity</th>
						<th>S.Item</th>
						<th>S.Quantity</th>
						<th>R.Item</th>
						<th>R.Quantity</th>
						<th>U.Price</th>
						<th>Amount(CAD)</th>
					</tr>
				</thead>
				<tbody>
					@foreach($project_details as $key=>$project)
					<tr>
						<td>{{ $project->finished_description }}</td>
						<td>{{ $project->finished_quantity }}</td>
						<td>{{ $project->semi_description}}</td>
						<td>{{ $project->semi_quantity * $project->finished_quantity}}</td>
						<td class="material">{{ $project->material_description }}</td>
						<td style="text-align: right;">{{ $project->quantity_raw * $project->semi_quantity * $project->finished_quantity}}</td>
						<td style="text-align: right;">{{ number_format($project->price_raw,2)}}</td>
						<td class="amount" style="text-align: right;">{{ $project->price_raw * $project->quantity_raw * $project->semi_quantity * $project->finished_quantity}}
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</section>
</div>

@endsection
@section('script')
<script type="text/javascript">
	$('#find_finished').on('click',function(){
		$('#finished_form').modal('show')
	})

	$('#search_finished').autocomplete({
		source: "{{ URL::route('searchFinished')}}",
		select:function(key,value){
			$('#finished_number').val(value.item.id);
			$('#finished_description').val(value.item.value);	
		}
	})

	totalValue();
	MergeCommonRows($('#project-table'));

	$('#finished_number').on('change',function(){
		var number = $(this).val();
		var dataNumber = {'finished_number':number};
		$.ajax({
			type: 'GET',
			url: '{{ URL::route('findFinishedInfo')}}',
			datatype: 'json',
			data: dataNumber,
			success: function(finished_info){
				$('#finished_description').val(finished_info.finished_description);
			}
		})
	})

	function totalValue(){
		var total_value = 0;
		$('.material').each(function(i,e){
			var tr = $(this).parents('tr');
			var amount = tr.find('.amount').html();
			//console.log(amount);
			total_value += parseFloat(amount);
			
			 $('#total_value').val(total_value);
			 console.log(total_value);
		})
	}

	function MergeCommonRows(table){
		var firstColumnBrakes = [];
		$.each(table.find('th'),function(i){
			var previous = null, cellToExtend = null, rowspan = 1;
			table.find("td:nth-child(" + i + ")").each(function(index,e){
				var jthis = $(this), content = jthis.text();
				if(previous == content && content !== "" && $.inArray(index,firstColumnBrakes) === -1){
					jthis.addClass('hidden');
					cellToExtend.attr("rowspan",(rowspan = rowspan+1));
				} else {
					if (i ===1) firstColumnBrakes.push(index);
					rowspan = 1;
					previous = content;
					cellToExtend = jthis;
				}
				
			});
		});
		$('td.hidden').remove();
	}

$('#error').on('click',function(){
    $('#error_box').modal('show')
});
</script>

@endsection
