<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Title;
use App\Country;
use App\Vendor;

class VendorController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function vendorIndex()
    {
    	return view('vendor.index');
    }

    public function vendorPage(){
    	$titles = Title::orderBy('title','ASC')->get();
    	$countries = Country::orderBy('country','ASC')->get();
    	return view('vendor.create',compact('titles','countries'));
    }

    public function createVendor(Request $request)
    {
        $message = [
            'vendor_name.required'=>'Please input vendor name',
            'address_1.required'=>'Please input address',
            'province_1.required'=>'Please input province',
            'country_code.required'=>'Please input country',
            'tel.required'=>'Please input telephone number',
            'email.email'=>'Please input correct email address',

        ];
        $validator = Validator::make($request->all(),[
                        'vendor_name'=>'required|max:150',
                        'address_1'=>'required|max:200',
                        'province_1'=>'required|max:50',
                        'country_code'=>'required',
                        'tel'=>'required',
                        'email'=>'nullable|email'

        ], $message);

        if($validator->passes())
        {
    		Vendor::create($request->all());
            $vendor_number = Vendor::latest('vendors.vendor_number')->value('vendor_number');
            return response()->json(['success'=>'New vendor number '. $vendor_number. ' was created.']);
    	}
        return response()->json(['fail'=>$validator->errors()->all()]);
    }

    public function searchVendor(Request $request)
    {
    	$term = $request->term;
    	$vendors = Vendor::where('vendor_name','LIKE','%'.$term.'%')->get();
    	$results = array();
    	foreach ($vendors as $key=>$value)
    	{
    		$results[] = ['id'=>$value->vendor_number,'value'=>$value->vendor_name];
    	}
    	return response()->json($results);
    }

    public function findVendorInfo(Request $request)
    {
    	$vendor_number = $request->vendor_number;
    	$vendor_info= Vendor::where('vendor_number',$vendor_number)->first();
    	return response()->json(['name'=>'kimhong']);
    }

    public function viewVendor(Request $request)
    {
    	$vendor_number = $request->vendor_number;
    	$vendor_numbers = Vendor::pluck('vendor_number')->all();
    	if(!in_array($vendor_number, $vendor_numbers)){
    		return redirect()->route('vendorIndex')->withMessage('Vendor number '. $vendor_number.' does not exist.');
    	} else{
	    	$vendor = Vendor::where('vendor_number',$vendor_number)->first();
	    	$titles = Title::orderBy('title','ASC')->get();
	    	$countries = Country::orderBy('country','ASC')->get();
	    	return view('vendor.view',compact('vendor','titles','countries'));
    	}

    }

    public function updateVendor(Request $request)
    {
        $message = [
            'vendor_name.required'=>'Please input vendor name',
            'address_1.required'=>'Please input address',
            'province_1.required'=>'Please input province',
            'country_code.required'=>'Please input country',
            'tel.required'=>'Please input telephone number',
            'email.email'=>'Please input correct email address',

        ];
    	$validator = Validator::make($request->all(),[
                        'vendor_name'=>'required|max:150',
                        'address_1'=>'required|max:200',
                        'province_1'=>'required|max:50',
                        'country_code'=>'required',
                        'tel'=>'required',
                        'email'=>'nullable|email'

        ], $message);

        if($validator->passes())
        {
        	$vendor_number = $request->vendor_number;
        	Vendor::updateOrCreate(['vendor_number'=>$vendor_number],$request->all());
            return response()->json(['success'=>'Vendor number '. $vendor_number .' has been updated.']);
    	}
        return response()->json(['fail'=>$validator->errors()->all()]);
    }

    public function deleteVendor(Request $request)
    {
    	$vendor_number = $request->vendor_number;
    	Vendor::destroy($vendor_number);
    	return response()->json(['success'=>'Vendor number '.$vendor_number.' has been deleted']);
    }
    

}
