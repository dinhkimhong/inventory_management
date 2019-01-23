<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MaterialsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Material;
// use Input;
use DB;
use Auth;

class DataController extends Controller
{
    // public function export() 
    // {
    //     return Excel::download(new MaterialsExport, 'materials.xlsx');
    // }

    public function importMaterial(Request $request)
    {
        if(Auth::user()->authorizeRoles('AD')){
        	$path = $request->file('material')->getRealPath();
        	Excel::load($path,function($reader){
        		$reader->each(function($sheet){
        			Material::create($sheet->toArray());	
        		});
        	});
        	return back();
        }
    }

    public function exportMaterial()
    {
    	$export = Material::all();
    	Excel::create('Material',function($excel) use($export){
    		$excel->sheet('Sheet 1',function($sheet)use($export){
    			$sheet->fromArray($export);
    		});
    	})->export('xlsx');
    }
}
