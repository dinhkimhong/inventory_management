<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Semi;
use App\SemiDetail;
use App\FinishedGoods;
use App\FinishedGoodsDetail;
use App\Project;
use App\ProjectDetail;
use Auth;

class BOMController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function semiPage()
    {
    	return view('bom.semi_create');
    }

   	public function createSemi(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    				'semi_description'=>'required|max:200',
    	]);

    	$semi = new Semi;
    	$semi->semi_description = $request->semi_description;
    	$semi->created_by = $request->created_by;

    	if($validator->passes())
    	{
    		if($semi->save())
    		{
    			foreach($request->material_number as $key=>$value)
    			{
    				$semi_number = $semi->semi_number;
    				SemiDetail::create(['semi_number'=>$semi_number,
    								'material_number'=>$value,
    								'quantity_raw'=>$request->quantity_raw[$key],
    								'price_raw'=>$request->moving_price[$key],
    								'remark'=>$request->remark[$key],
    								]);
    			}
    			return back()->withSuccess('New Semifinished Goods number '. $semi_number. ' was created.');
    		}
    	}

    	return back()->withErrors($validator);
    }

    public function finishedPage()
    {
    	return view('bom.finished_create');
    }

    public function searchSemi(Request $request)
    {
    	$term_semi = $request->term;
        $semis = Semi::where('semi_description','LIKE','%'.$term_semi.'%')->get();
        $results = [];
        foreach($semis as $key=>$value){
            $results[]=['id'=>$value->semi_number,'value'=>$value->semi_description];
        }
        return response()->json($results);

    }


    public function findSemiInfo(Request $request)
    {
        $semi_info = Semi::select('semi_description')->where('semi_number',$request->semi_number)->first();
        return response()->json($semi_info);
    }


    public function createFinished(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'finished_description'=>'required|max:200',
        ]);

        $finished = new FinishedGoods;
        $finished->finished_description = $request->finished_description;
        $finished->created_by = $request->created_by;

        if($validator->passes() && $finished->save())
        {      
            foreach($request->semi_number as $key=>$value)
                {
                $finished_number = $finished->finished_number;

                FinishedGoodsDetail::create(['finished_number'=>$finished_number,
                                         'semi_number'=>$value,
                                         'semi_quantity'=>$request->semi_quantity[$key],
                                         'remark'=>$request->remark[$key],
                                     ]);
                return back()->withSuccess('New Finished Goods number '. $finished_number. ' was created.');
                }
                
        }
        return back()->withErrors($validator);
    }

    public function projectPage(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'project_number'=>'unique:projects|required|max:5',
        ]);
        $project = new Project;
        $project_number = $request->project_number;
        $project->project_number = $project_number;
        $project->created_by = Auth::user()->id;
        if($validator->passes())
        {
            $project->save();
        }

        $project_details = $this->BOMDetails($project_number)->get();
        return view('bom.project_create',compact('project_details'))->with('project_number',$project_number);
    }

    public function findFinishedInfo(Request $request)
    {
        $finished_info = FinishedGoods::select('finished_description')->where('finished_number',$request->finished_number)->first();
        return response()->json($finished_info);
    }

    public function searchFinished(Request $request)
    {
        $term_finished = $request->term;
        $finished = FinishedGoods::where('finished_description','LIKE','%'.$term_finished.'%')->get();
        $results = array();
        foreach($finished as $key=>$value)
        {
            $results[]=['id'=>$value->finished_number,'value'=>$value->finished_description];
        }
        return response()->json($results);
    }

    public function projectIndex()
    {
    	return view('bom.project');
    }

    public function createProject(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'finished_number'=>'required',
            'finished_quantity'=>'required'
        ]);

        if($validator->passes())
        {
            ProjectDetail::create($request->all());
            return back();
        }
        return back()->withErrors($validator);
    }

    public function BOMDetails($p_number)
    {
        return Project::join('project_details','project_details.project_number','=','projects.project_number')
                        ->join('finished_goods','finished_goods.finished_number','=','project_details.finished_number')
                        ->join('finished_goods_details','finished_goods_details.finished_number','=','finished_goods.finished_number')
                        ->join('semis','semis.semi_number','=','finished_goods_details.semi_number')
                        ->join('semi_details','semi_details.semi_number','=','semis.semi_number')
                        ->join('materials','materials.material_number','=','semi_details.material_number')
                        ->where('projects.project_number',$p_number);
    
    }

    public function bomPage()
    {
        return view('bom.index');
    }



}
