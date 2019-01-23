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

    public function inboundIndex()
    {
    	return view('inbound.index');
    }

    public function inboundPage(Request $request)
    {
        $po_number = $request->po_number;
    	$po_numbers = PurchaseOrder::pluck('po_number')->all();
        $inbound_po_numbers = Inbound::pluck('po_number')->all();
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
    				->where('po_number',$po_number)->first();
        if(in_array($po_number,$po_numbers) && in_array($po_number,$inbound_po_numbers)){
            $in = Inbound::join('inbound_details','inbound_details.inbound_number','=','inbounds.inbound_number')
                           ->select('inbound_details.material_number',DB::raw('SUM(receipt_quantity) as past_receipt_quantity'))
                           ->where('po_number',$po_number)
                            ->groupBy('inbound_details.material_number');

            $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                ->joinSub($in,'in',function($join){
                    $join->on('purchase_order_details.material_number','=','in.material_number');
                })
                ->where('purchase_order_details.po_number',$po_number)
                ->get();

            // dd($purchase_details);
    		return view('inbound.create',compact('purchase','purchase_details'));	
    	} else if(in_array($po_number,$po_numbers)){
            $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                ->where('po_number',$po_number)
                ->get();
            return view('inbound.create',compact('purchase','purchase_details')); 
        } else {
    		return redirect()->route('inboundIndex')->withMessage('This purchase order does not exist.');
    	}
    }

public function createInbound(Request $request)
    {
        $inbound = new Inbound();
        $inbound->po_number = $request->po_number;
        $inbound->receipt_date = $request->receipt_date;
        $inbound->created_by = Auth::user()->id;
         // $inbound->save();

        $validator = Validator::make($request->all(),[
                'receipt_quantity.*'=>'required',
                'batch_number.*'=>'required',
                'total_receipt_quantity'=>'gt:0',
        ]);

        if($validator->passes()){
            if($inbound->save())
            {
                foreach($request->material_number as $key=>$value)
                {
                    $inbound_number = $inbound->inbound_number;
                    InboundDetails::insert(['material_number'=>$value,
                                            'inbound_number'=>$inbound_number,
                                            'receipt_quantity'=>$request->receipt_quantity[$key],
                                            'batch_number'=>$request->batch_number[$key],
                                            'ordered_quantity'=>$request->ordered_quantity[$key],
                    ]);
                    $material = Material::find($value);
                    $inventory_value_bf = $material->moving_price*$material->inventory_quantity;
                    $material->inventory_quantity += $request->receipt_quantity[$key];
                    $material->moving_price = ($inventory_value_bf +($request->receipt_quantity[$key] * ($request->unit_price[$key]+$request->import_duty[$key]+$request->freight_handling_cost[$key])))/$material->inventory_quantity;
                    $material->save();
                }

                return redirect()->route('inboundIndex')->withSuccess('New inbound number '. $inbound_number .' was created.');

            }
        }
        return back()->withErrors($validator);
    }    
}
