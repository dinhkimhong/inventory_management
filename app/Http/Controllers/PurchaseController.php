<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DeliveryTerm;
use App\Currency;
use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use DB;
use Auth;

class PurchaseController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function purchasePage()
    {
    	$delivery_terms = DeliveryTerm::orderBy('delivery_term','ASC')->get();
    	$currencies = Currency::orderBy('currency','ASC')->get();
    	return view('purchase.create',compact('delivery_terms','currencies'));
    }

    public function purchaseIndex()
    {
    	return view('purchase.index');
    }

    public function createPurchase(Request $request)
    {
        $message = [
            'currency.required'=>'Please input currency',
            'vendor_number.required'=>'Please input vendor',
            'delivery_term.required'=>'Please input delivery term',
            'material_number.*.required'=>'Please input at least one material',
            'quantity.*.required'=>'Please input quantity',
            'unit_price.*.required'=>'Please input unit price',
        ];

        $validator = Validator::make($request->all(),[
                    'currency'=>'required',
                    'vendor_number'=>'required',
                    'delivery_term'=>'required',
                    'material_number.*'=>'required',
                    'quantity.*'=>'required',
                    'unit_price.*'=>'required',

        ], $message);
        if($validator->passes()){
            if(PurchaseOrder::create($request->all()))
            {
                foreach($request->material_number as $key=>$value){
                    $po_number = PurchaseOrder::latest('purchase_orders.po_number')->value('po_number');
                    PurchaseOrderDetail::insert(['po_number'=>$po_number,
                                                'material_number'=>$value,
                                                'quantity'=>$request->quantity[$key],
                                                'import_duty'=>$request->import_duty[$key],
                                                'freight_handling_cost'=>$request->freight_handling_cost[$key],
                                                'unit_price'=>$request->unit_price[$key],
                                            ]);
                }
                session()->flash('success','New purchase order no. '. $po_number. ' was created');
                return back();
            }
        }
        return back()->withErrors($validator);
    }



    public function viewPurchase(Request $request)
    {
        $currencies = Currency::orderBy('currency','ASC')->get();
        $delivery_terms = DeliveryTerm::orderBy('delivery_term','ASC')->get();

        $po_number = $request->po_number;
        $po_numbers = PurchaseOrder::pluck('po_number')->all();
        // $inbound_po_numbers = Inbound::pluck('po_number')->all();
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
                    ->where('po_number',$po_number)->first();
        $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$request->po_number)
                    ->get(); 
                $po_numbers = PurchaseOrder::pluck('purchase_orders.po_number')->all();
            // $po_number_inbound = DB::table('inbounds')->where('po_number',$po_number)->get();
        if(in_array($po_number,$po_numbers)){
            $purchase_details = DB::table('purchase_order_details')->join('materials','materials.material_number','=','purchase_order_details.material_number')
                // ->leftJoin('inbound_details','inbound_details.number_po','=','purchase_order_details.number_po')
                ->where('po_number',$po_number)
                ->select('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost')
                ->groupBy('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost')
                ->get();
            return view('purchase.view',compact('purchase','purchase_details','currencies','delivery_terms'));
		}else{
            return back()->withMessage('Purchase order number '. $request->po_number . ' doest not exists.');
        }

    }


    public function updatePurchase(Request $request)
    {   
        $purchase = PurchaseOrder::find($request->po_number);
        $purchase->delivery_term = $request->delivery_term;
        $purchase->delivery_place = $request->delivery_place;
        $purchase->vendor_number =  $request->vendor_number;
        $purchase->contact = $request->contact;
        $purchase->email =  $request->email;
        $purchase->total_freight_handling_cost = $request->total_freight_handling_cost;
        $purchase->user_id = $request->user_id;
        $purchase->currency = $request->currency;
        $purchase->delivery_date = $request->delivery_date;
        $purchase->payment_term = $request->payment_term;
        $purchase->shipping_instruction = $request->shipping_instruction;

        $message = [
            'currency.required'=>'Please input currency',
            'vendor_number.required'=>'Please input vendor',
            'delivery_term.required'=>'Please input delivery term',
            'material_number.*.required'=>'Please input at least one material',
            'quantity.*.required'=>'Please input quantity',
            'unit_price.*.required'=>'Please input unit price',
        ];

        $validator = Validator::make($request->all(),[
                    'currency'=>'required',
                    'vendor_number'=>'required',
                    'delivery_term'=>'required',
                    'material_number.*'=>'required',
                    'quantity.*'=>'required',
                    'unit_price.*'=>'required',

        ], $message);
        if($validator->passes()){
            if($purchase->update()){
                DB::table('purchase_order_details')->where('po_number','=',$request->po_number)->delete();
                    foreach($request->material_number as $key=>$value){
                        $po_number = $request->po_number;
                        PurchaseOrderDetail::updateOrCreate(['po_number'=>$po_number,
                                                    'material_number'=>$value,
                                                    'quantity'=>$request->quantity[$key],
                                                    'import_duty'=>$request->import_duty[$key],
                                                    'freight_handling_cost'=>$request->freight_handling_cost[$key],
                                                    'unit_price'=>$request->unit_price[$key]
                                                ]);
                    }
                session()->flash('success','Purchase order no. '. $po_number. ' was updated');
                return redirect()->route('viewPurchase',['po_number'=>$request->po_number]);
            }
        }
        return back()->withErrors($validator);
    }

    public function deletePurchase(Request $request)
    {
        if ($request->ajax())
        {
            DB::table('purchase_order_details')->where('po_number','=',$request->po_number)->delete();
            PurchaseOrder::destroy($request->po_number);
        }
    }

    public function printPurchase($po_number)
    {
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
                    ->where('po_number',$po_number)->first();
        $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$po_number)
                    ->get(); 
        return view('purchase.print',compact('purchase','purchase_details'));   
    }
}
