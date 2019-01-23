<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\Validator;
use App\Unit;
use App\MaterialGroup;
use App\Country;
use App\Currency;
use App\Material;
use DB;
use Auth;

class MaterialController extends Controller
{


    public function materialPage(){
    	$units = Unit::all();
    	$material_groups = MaterialGroup::orderBy('material_group_id','ASC')->get();
    	$countries = Country::orderBy('country_code','ASC')->get();
    	$currencies = Currency::orderBy('currency','ASC')->get();
    	return view('material.create',compact('units','material_groups','countries','currencies'));
    }

    public function materialIndex()
    {
    	return view('material.index');
    }

    public function createMaterial(Request $request)
    {
    	$planning = isset($request->planning) ? 1 : 0;
        $gst = isset($request->gst) ? 1 : 0;
        $pst = isset($request->pst) ? 1 : 0;
        $hst = isset($request->hst) ? 1 : 0;

        $message = [
            'material_description.required'=>'Please input Material Description',
            'material_description.max'=>'Number of letter in Material Description must be less than 100',
            'unit.required'=>'Please input Unit',
            'material_group_id.required'=>'Please input Material Group',
            'origin.required'=>'Please input Origin',
            'tarrif_code.required'=>'Please input Tarrif Code',
            'currency.required'=>'Please input Currency',
        ];

        $validator = Validator::make($request->all(),[
    			'material_description'=>'required|max:100',
    		    'unit'=>'required',
                'material_group_id'=>'required',
                'origin'=>'required',
                'tarrif_code'=>'required',
                'currency'=>'required',

    	],$message);
      
        $material = new Material(['material_description'=>$request->material_description,
                            'mfg_material_number'=>$request->mfg_material_number,
                            'unit'=>$request->unit,
                            'material_group_id'=>$request->material_group_id,
                            'manufacturer'=>$request->manufacturer,
                            'weight'=>$request->weight,
                            'origin'=>$request->origin,
                            'gst'=>$gst,
                            'pst'=>$pst,
                            'hst'=>$hst,
                            'import_tax'=>$request->import_tax,
                            'export_tax'=>$request->export_tax,
                            'tarrif_code'=>$request->tarrif_code,
                            'discount'=>$request->discount,
                            'inventory_quantity'=>$request->inventory_quantity,
                            'planning'=>$planning,
                            'safety_stock'=>$request->safety_stock,
                            'purchasing_price'=>$request->purchasing_price,
                            'selling_price'=>$request->selling_price,
                            'moving_price'=>$request->moving_price,
                            'currency'=>$request->currency,
                        ]);
    	if($validator->passes())
    	{
            Auth::user()->materials()->save($material);
  		    $material_number = Material::latest('materials.material_number')->value('material_number');
    		return response()->json(['success'=>'New material '. $material_number. ' was created.']);
    	}
    	return response()->json(['fail'=>$validator->errors()->all()]);
    }

    public function searchMaterial(Request $request)
    {
        $term = $request->term;
        $materials = Material::where('material_description','LIKE','%'.$term.'%')
        ->get();
        $results = array();
        foreach ($materials as $key =>$value)
        {
            $results[]=['id'=>$value->material_number,'value'=>$value->material_description,'unit'=>$value->unit,'moving_price'=>$value->moving_price];
        }
        return response()->json($results);
    }

    public function findMaterialInfo(Request $request)
    {
    	$material_number = $request->material_number;
    	$material_info = Material::select('material_description','unit','moving_price')->where('material_number',$material_number)->first();
    	return response()->json($material_info);

    }

    public function viewMaterial(Request $request)
    {
    	$material_number = $request->material_number;
    	$material_numbers = DB::table('materials')->pluck('material_number')->all();

    	if(!in_array($material_number, $material_numbers)){
    		return redirect()->route('materialIndex')->withMessage('Material number '.$material_number.' does not exist.');
    	} else{
    		$material = Material::where('material_number',$material_number)->first();
    		$units = Unit::all();
    		$material_groups = MaterialGroup::orderBy('material_group_id','ASC')->get();
    		$currencies = Currency::orderBy('currency','ASC')->get();
    		$countries = Country::orderBy('country_code','ASC')->get();
    		return view('material.view',compact('material','units','material_groups','currencies','countries'));
    	}
    }

    public function updateMaterial(Request $request)
    {
        $planning = isset($request->planning) ? 1 : 0;
        $gst = isset($request->gst) ? 1 : 0;
        $pst = isset($request->pst) ? 1 : 0;
        $hst = isset($request->hst) ? 1 : 0;

        $message = [
            'material_description.required'=>'Please input Material Description',
            'material_description.max'=>'Number of letter in Material Description must be less than 100',
            'unit.required'=>'Please input Unit',
            'material_group_id.required'=>'Please input Material Group',
            'origin.required'=>'Please input Origin',
            'tarrif_code.required'=>'Please input Tarrif Code',
            'currency.required'=>'Please input Currency',
        ];

        $validator = Validator::make($request->all(),[
                'material_description'=>'required|max:100',
                'unit'=>'required',
                'material_group_id'=>'required',
                'origin'=>'required',
                'tarrif_code'=>'required',
                'currency'=>'required',

        ],$message);

    	if($validator->passes())
    	{
    		$material_number = $request->material_number;
    		Material::updateOrCreate(['material_number'=>$material_number],
                            ['material_description'=>$request->material_description,
                            'mfg_material_number'=>$request->mfg_material_number,
                            'unit'=>$request->unit,
                            'material_group_id'=>$request->material_group_id,
                            'manufacturer'=>$request->manufacturer,
                            'weight'=>$request->weight,
                            'origin'=>$request->origin,
                            'gst'=>$gst,
                            'pst'=>$pst,
                            'hst'=>$hst,
                            'import_tax'=>$request->import_tax,
                            'export_tax'=>$request->export_tax,
                            'tarrif_code'=>$request->tarrif_code,
                            'discount'=>$request->discount,
                            'inventory_quantity'=>$request->inventory_quantity,
                            'planning'=>$planning,
                            'safety_stock'=>$request->safety_stock,
                            'purchasing_price'=>$request->purchasing_price,
                            'selling_price'=>$request->selling_price,
                            'moving_price'=>$request->moving_price,
                            'currency'=>$request->currency,
                        ]);
    		return response()->json(['success'=>'Material number '. $material_number. ' has been updated.']);
    	}
    	return response()->json(['fail'=>$validator->errors()->all()]);
    }

    public function deleteMaterial(Request $request)
    {
        	$material_number = $request->material_number;
        	Material::destroy($material_number);
        	return response()->json(['success'=>'Material number '.$material_number.' has been deleted.']);
    }

}
