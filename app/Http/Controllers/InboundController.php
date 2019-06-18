<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Inbound;
use App\InboundDetails;
use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\Material;
use Auth;
use DB;

class InboundController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	return view('inbound.index');
    }

    public function create(Request $request)
    {
        $po_number = $request->po_number;
    	$po_numbers = PurchaseOrder::pluck('po_number')->all();
        $inbound_po_numbers = Inbound::pluck('po_number')->all();
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
    				->where('po_number',$po_number)->first();
        if(in_array($po_number, $po_numbers)){
            if(in_array($po_number,$inbound_po_numbers)){
                $in = Inbound::join('inbound_details','inbound_details.inbound_number','=','inbounds.inbound_number')
                               ->select('inbound_details.pod_number',DB::raw('SUM(receipt_quantity) as past_receipt_quantity'))
                               ->where('po_number',$po_number)
                                ->groupBy('inbound_details.pod_number');

                $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->joinSub($in,'in',function($join){
                        $join->on('purchase_order_details.number','=','in.pod_number');
                    })
                    ->where('purchase_order_details.po_number',$po_number)
                    ->get();
                return view('inbound.create',compact('purchase','purchase_details'));   
            } else{
                $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$po_number)
                    ->get();
                return view('inbound.create',compact('purchase','purchase_details')); 
            } 

        }else {
    		return redirect()->route('inboundIndex')->withMessage('This purchase order does not exist.');
    	}
    }

public function new(Request $request)
    {
        $inbound = new Inbound();
        $inbound->po_number = $request->po_number;
        $inbound->receipt_date = $request->receipt_date;
        $inbound->created_by = Auth::user()->id;

        $validator = Validator::make($request->all(),[
                'total_receipt_quantity'=>'gt:0',
        ]);

        if($validator->passes()){
            if($inbound->save())
            {
                foreach($request->pod_number as $key=>$value)
                {
                    $inbound_number = $inbound->inbound_number;
                    if(!empty($request->receipt_quantity[$key]) && !empty($request->batch_number[$key])){
                        InboundDetails::insert(['inbound_number'=>$inbound_number,
                                                'pod_number'=>$value,                        
                                                'receipt_quantity'=>$request->receipt_quantity[$key],
                                                'batch_number'=>$request->batch_number[$key],
                        ]);
                        $this->updateMovingPrice($value, $request->receipt_quantity[$key]);                        
                    }
                }
                return redirect()->route('inboundIndex')->withSuccess('New inbound number '. $inbound_number .' was created.');
            }
        }
        return back()->withInput()->withErrors($validator);
    }    

    public function updateMovingPrice($pod_number, $new_quantity){

        //get information from Purchase Order Details
        $purchase_order_detail = PurchaseOrderDetail::where('number',$pod_number)->first();
        $material_number = $purchase_order_detail->material_number;
        $unit_price = $purchase_order_detail->unit_price;
        $import_duty = $purchase_order_detail->import_duty;
        $freight_handling_cost = $purchase_order_detail->freight_handling_cost;

        //get information from material
        $material = Material::find($material_number);
        $old_moving_price = $material->moving_price;


        //get received_quantity & delivered_quantity

        $received_quantity = (int)DB::table('inbound_details')
                            ->leftJoin('purchase_order_details','inbound_details.pod_number','=','purchase_order_details.number')
                            ->select(DB::raw('SUM(receipt_quantity) as received_quantity'))
                            ->where('purchase_order_details.material_number',$material_number)
                            ->first()->received_quantity;
        $delivered_quantity = (int)DB::table('outbound_details')
                            ->leftJoin('sales_order_details','sales_order_details.number','=','outbound_details.sod_number')
                            ->select(DB::raw('SUM(delivery_quantity) as delivered_quantity'))
                            ->where('sales_order_details.material_number',$material_number)
                            ->first()->delivered_quantity;    

        //calculate new moving_price

        $moving_price = (($new_quantity * ($unit_price + $import_duty + $freight_handling_cost)) + (($received_quantity - $new_quantity) * $old_moving_price)) / $received_quantity;

        //update new moving price to table
        $material->moving_price = $moving_price;
        $material->save();     
    }
}
