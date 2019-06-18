<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DeliveryTerm;
use App\Currency;
use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\InboundDetails;
use App\Inbound;
use DB;
use Auth;

class PurchaseController extends Controller
{

    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function create()
    {
    	$delivery_terms = DeliveryTerm::orderBy('delivery_term','ASC')->get();
    	$currencies = Currency::orderBy('currency','ASC')->get();
    	return view('purchase.create',compact('delivery_terms','currencies'));
    }

    public function index()
    {
    	return view('purchase.index');   
    }

    public function new(Request $request)
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
                
                return back()->withSuccess('New purchase order no. '. $po_number. ' has been created');
            }
        }
        return back()->withInput()->withErrors($validator);
    }



    public function view($po_number)
    {
        $currencies = Currency::orderBy('currency','ASC')->get();
        $delivery_terms = DeliveryTerm::orderBy('delivery_term','ASC')->get();

        $po_numbers = PurchaseOrder::pluck('po_number')->all();
        // $inbound_po_numbers = Inbound::pluck('po_number')->all();
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
                    ->where('po_number',$po_number)->first();
        $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$po_number)
                    ->get(); 
        $po_numbers = PurchaseOrder::pluck('po_number')->all();
        $po_number_array_inbound = Inbound::pluck('po_number')->all();
        $pod_number_array_inbound_detail = InboundDetails::pluck('pod_number')->all();

        if(in_array($po_number,$po_numbers)){
            $purchase_details = DB::table('purchase_order_details')->join('materials','materials.material_number','=','purchase_order_details.material_number')
                ->where('po_number',$po_number)
                ->select('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost','purchase_order_details.number')
                ->groupBy('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost','purchase_order_details.number')
                ->get();
            return view('purchase.view',compact('purchase','purchase_details','currencies','delivery_terms','po_number_array_inbound','pod_number_array_inbound_detail'));
		}else{
            return back()->withError('Purchase order number '. $po_number . ' doest not exists.');
        }

    }

    public function updatePage($po_number){
        $currencies = Currency::orderBy('currency','ASC')->get();
        $delivery_terms = DeliveryTerm::orderBy('delivery_term','ASC')->get();

        $po_numbers = PurchaseOrder::pluck('po_number')->all();

        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
                    ->where('po_number',$po_number)->first();
        $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$po_number)
                    ->get(); 
        $po_numbers = PurchaseOrder::pluck('po_number')->all();
        $po_number_array_inbound = Inbound::pluck('po_number')->all();
        $pod_number_array_inbound_detail = InboundDetails::pluck('pod_number')->all();

        if(in_array($po_number,$po_numbers)){
            $purchase_details = DB::table('purchase_order_details')->join('materials','materials.material_number','=','purchase_order_details.material_number')
                ->join('inbound_details','inbound_details.pod_number','=','purchase_order_details.number')
                ->where('po_number',$po_number)
                ->select('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost','purchase_order_details.number','inbound_details.pod_number', DB::raw('SUM(receipt_quantity) as receipt_quantity'))
                ->groupBy('purchase_order_details.material_number','purchase_order_details.po_number','materials.material_description','materials.unit','purchase_order_details.quantity','purchase_order_details.unit_price','purchase_order_details.import_duty','purchase_order_details.freight_handling_cost','purchase_order_details.number', 'inbound_details.pod_number')
                ->get();
            return view('purchase.update',compact('purchase','purchase_details','currencies','delivery_terms','po_number_array_inbound','pod_number_array_inbound_detail'));
        }else{
            return back()->withError('Purchase order number '. $po_number . ' doest not exists.');
        }
    }

    public function update(Request $request)
    {   
        $po_number = $request->po_number;
        $purchase = PurchaseOrder::find($po_number);

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
                //get pod_number_array in inbound_details
                $pod_number_array_inbound = DB::table('inbound_details')
                            ->leftJoin('inbounds','inbounds.inbound_number','=','inbound_details.inbound_number')
                            ->select('inbound_details.pod_number')
                            ->where('inbounds.po_number',$po_number)
                            ->pluck('pod_number')->all();

                //get number array in purchase order details
                $number_array_in_pod = PurchaseOrderDetail::where('po_number',$po_number)
                                    ->pluck('number')->all();

                $number_array = $request->number;


                foreach($request->material_number as $key=>$value){
                    if(in_array($request->number[$key], $number_array_in_pod)){                    
                        if(in_array($request->number[$key], $pod_number_array_inbound)){
                            $receipt_quantity_per_pdonumber = (int)InboundDetails::select(DB::raw('SUM(receipt_quantity) as receipt_quantity'))
                                                ->where('pod_number',$request->number[$key])
                                                ->groupBy('pod_number')->first()->receipt_quantity;
                            //if quantity in purchase order less then receipt quantity
                            if((int)$request->quantity[$key] < $receipt_quantity_per_pdonumber){
                                return back()->withError('Unable to update this purchase order as quantity must be greater then receipt quantity');
                            //if quantity in purchase order >= receipt quantity, just update quantity
                            }else {
                                PurchaseOrderDetail::where('number',$request->number[$key])
                                                ->update(['quantity'=>$request->quantity[$key]
                                ]);                             
                            }
                        }else{
                             PurchaseOrderDetail::where('number',$request->number[$key])
                                                ->update(['material_number'=>$value,
                                                        'quantity'=>$request->quantity[$key],
                                                        'import_duty'=>$request->import_duty[$key],
                                                        'freight_handling_cost'=>$request->freight_handling_cost[$key],
                                                        'unit_price'=>$request->unit_price[$key],
                                                    ]);
                        }
                    }else{
                        PurchaseOrderDetail::insert(['po_number'=>$po_number,
                                                        'material_number'=>$value,
                                                        'quantity'=>$request->quantity[$key],
                                                        'import_duty'=>$request->import_duty[$key],
                                                        'freight_handling_cost'=>$request->freight_handling_cost[$key],
                                                        'unit_price'=>$request->unit_price[$key],
                                                    ]);
                    }
                }
                //delete row
                foreach($number_array_in_pod as $number_in_pod){
                    if(!in_array($number_in_pod, $number_array)){
                        PurchaseOrderDetail::where('number',$number_in_pod)->delete();
                    }
                }
                return redirect()->route('viewPurchase',$po_number)->withSuccess('Purchase order no. '. $po_number. ' was updated');
            }
        }
        return back()->withErrors($validator);
    }

    public function delete(Request $request)
    {
        if ($request->ajax())
        {
            DB::table('purchase_order_details')->where('po_number','=',$request->po_number)->delete();
            PurchaseOrder::destroy($request->po_number);
        }
    }

    public function print($po_number)
    {
        $purchase = PurchaseOrder::join('vendors','vendors.vendor_number','=','purchase_orders.vendor_number')
                    ->where('po_number',$po_number)->first();
        $purchase_details = PurchaseOrderDetail::join('materials','materials.material_number','=','purchase_order_details.material_number')
                    ->where('po_number',$po_number)
                    ->get(); 
        return view('purchase.print',compact('purchase','purchase_details'));   
    }
}
