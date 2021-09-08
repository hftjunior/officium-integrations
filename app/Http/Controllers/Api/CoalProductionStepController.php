<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CoalProductionSteps;
use App\Models\CoalProduction;

class CoalProductionStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productionSteps = CoalProductionSteps::all();
        return response()->json($productionSteps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = array();
        $rsProduction = array();
        $productionStep = CoalProductionSteps::find($id);
        $result = ["id" => $productionStep->id,
                   "coal_production_id" => $productionStep->coal_production_id,
                   "coal_step_id" => $productionStep->coal_step_id,
                   "dtinitial" => $productionStep->dtinitial,
                   "vol_wood" => $productionStep->vol_wood,
                   "diameter_wood" => $productionStep->diameter_wood,
                   "coal_stock_id" => $productionStep->coal_stock_id,
                   "vol_charcoal" => $productionStep->vol_charcoal,
                   "vol_atico" => $productionStep->vol_atico
                ];
        $production = CoalProduction::find($productionStep->coal_production_id);
        $result += ["coal_unit_id" => $production->coal_unit_id,
                    "coal_oven_id" => $production->coal_oven_id,
                    "round" => $production->round];
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['dtinitial', 'vol_wood', 'diameter_wood', 'vol_charcoal', 'vol_atico']);
        $productionStep = CoalProductionSteps::find($id);
        if($productionStep){
            try{
                $productionStep->update($data);
            }catch(Illuminate\Database\QueryException $e){
                    return response()->json(array(["message" => "Failed to update the registry"]), 404);
            }
        }else {
            return response()->json(array(["message" => "Register not found"]),404);
        }
        return response()->json($productionStep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
