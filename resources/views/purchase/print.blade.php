<!DOCTYPE html>
<html>
<head>
<title>Sprout Berry</title>

<style type="text/css">
html,body{
	padding: 0;
	margin: 0;
	width: 100%;
	background: #fff;
	font-family: Arial,'Sans Serif','Time News Romain';
	font-size: 10pt;
	}
p{
	line-height: 6px;
}
table{
	width: 700px;
	margin: 0 auto;
	text-align: left;
	border-collapse: collapse;

}

th{
	padding-left: 2px;
}

td{
	padding: 2px;
}


.verify{
	font-family: 'time news romain';
}

.imageAeu{width: 50px; height: 70px;}

.th {
	background-color: #ddd;
	border: 1px solid;
	text-align: center;
}

#container{
	width: 100%;
	margin: 0 auto;
}

.khm-os{ font-family: 'Time news Romain'; }

.divide{ width: 100%; margin: 0 auto; }

hr{
	width: 100%;
	margin-right: 0;
	margin-left: 0;
	padding: 0;
	margin-top: 35px;
	margin-bottom: 20px;
	border: 0 none;
	border-top: 1px dashed #322f32;
	background: none;
	height: 0;
}

.length-limit{max-height: 700px; min-width: 350px;}

.line-row{
	border: 1px solid;
}
</style>

</head>
<body>
<table><td><button onclick="printContent('divide')" style="float:right;">Print</button></td></table>

<div id="divide">

	<div id="container">
		<div class="length-limit">
			<table>
				<tr>
					<td style="width: 140px; ">
					</td>
					<td>
						<h2 style="width: 250px"><b>PURCHASE ORDER</b></h2>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align: right;"></td>
					<td colspan="0" style="text-align: right;padding-left: 80px;">PO no.: {{ $purchase->po_number}} |  Date: {{ $purchase->created_at->format('m-d-Y') }}</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"></td>
					<td colspan="0" style="text-align: right;padding-left: 80px;">Delivery date: {{ $purchase->delivery_date->format('m-d-Y') }}</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"></td>
					<td colspan="0" style="text-align: right;padding-left: 80px;">Delivery term: {{ $purchase->delivery_term. " ". $purchase->delivery_place}} </td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"></td>
					<td colspan="0" style="text-align: right;padding-left: 80px;">Payment term: {{ $purchase->payment_term }}</td>
				</tr>
			</table>


			<table>
				<tr>
					<th style="width: 350px;">
						<p><u>Buyer:</u></p>
						<p>Sprout Berry Corporation</p>
						<p style="font-weight: normal">#4 - 38886 Queens Way, </p>
						<p style="font-weight: normal">Squamish, BC V8B 0V2, Canada</p>
						<p style="font-weight: normal">Tel: +1-604-255-4561 |  Fax: +1-604-677-5826</p>
						<p style="font-weight: normal">Email: purchase@sproutberry.com</p>
					</th>
					<th >
						<p><u>Seller:</u></p>
						<p>{{ $purchase->vendor_name }}</p>
						<p style="font-weight: normal">{{ $purchase->address_1 }}</p>
						<p style="font-weight: normal">{{ $purchase->province_1. " " .$purchase->country_name }}</p>
						<p style="font-weight: normal">Contact person: {{ $purchase->contact }}</p>
						<p style="font-weight: normal">Email: {{ $purchase->email }}</p>
					</th>
				</tr>
			</table>	
		
			<table>
				<thead>
					<tr>
						<th colspan="5"></th>
						<th colspan="2" style="text-align: right;">Currency: {{ $purchase->currency }}</th>
					</tr>
					<tr>
						<th class="th" style="width: 10px">No</th>
						<th class="th" style="width: 25px;">Material number</th>
						<th class="th" style="width: 125px;">Description</th>
						<th class="th" style="width: 10px;">Unit</th>
						<th class="th" style="width: 20px;">Quantity</th>
						<th class="th" style="width: 20px;">Unit Price</th>
						<th class="th" style="width: 25px;">Total</th>

					</tr>
				</thead>

				<tbody>
					@foreach($purchase_details as $key=>$p)
					<tr>
						<td class="line-row" style="text-align: center;">
							{{ ++$key }}
						</td>
						<td class="line-row" style="text-align: center;">
							{{ $p->material_number}}
						</td>
						<td class="line-row">
							{{ $p->material_description }}
							{{ $p->remark}}
						</td>
						<td class="line-row">
							{{ $p->unit }}
						</td>
						<td class="line-row quantity" style="text-align: right;">
							{{ number_format($p->quantity,0) }}
						</td>
						<td class="line-row unit_price" style="text-align: right;">
							{{ number_format($p->unit_price,2) }}
						</td>
						<td class="line-row amount" style="text-align: right;">
							{{ $p->quantity * $p->unit_price }}
						</td>
					</tr>
					@endforeach
					<tr>
						<td colspan="6" class="line-row" style="text-align: center; font-weight: bold;">Total amount</td>
						<td class="line-row total_amount" style="text-align: right; font-weight: bold;"></td>
				</tbody>
			</table>
			<br>
			<table>
				<tr>
					<td>
						<b class="veriry"><u>Shipping instruction:</u></b>
						<p>{{ $purchase->shipping_instruction }}</p>						
					</td>

				</tr>
			</table>
			<table>
				<tr style="border-bottom: 1px solid black">
					<th style="width:350px">
						<p style="text-align: center;">Buyer:</p>
						<br><br><br><br><br>
						<p style="text-align: center;">Sprout Berry Corporation</p>
					</th>
					<th >
						<p style="text-align: center;">Acknowledged by Seller:</p>
						<br><br><br><br><br>
						<p style="text-align: center;">{{ $purchase->vendor_name }}</p>
					</th>
				</tr>
			</table>

			<table>
				<tr>
					<td>
						<b class="veriry">Note:</b>
						<ol style="padding-left: 10px;">
							<li>This Purchase Order is subject to our standard terms and conditions overleaf and deemed accepted upon execution.</li>
							<li>Please quote the above Purchase Order Number in all correspondence to us.</li>
							<li>We reserve the right to cancel our order without liability on our part if any or all the conditions stated in the Purchase Order cannot be fulfilled.</li>
							<li>For local purchases, please submit invoices with copy of signed Delivery Order to ensure prompt payment.</li>
						</ol>						
					</td>

				</tr>
			</table>
		</div>
	</div>

</div>

<script src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
totalAmount();
	function totalAmount(){
		var total_amount = 0;
		$('.amount').each(function(i,e){
			var tr = $(this).parents('tr');
			var amount = tr.find('.amount').html();
			total_amount += parseFloat(amount);
			$('.total_amount').html(total_amount);
		})
		
	}

	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
		window.close();
	}

</script>

</body>
</html>
