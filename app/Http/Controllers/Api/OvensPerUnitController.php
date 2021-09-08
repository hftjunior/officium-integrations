<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\CoalOven;

class OvensPerUnitController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $limit)
    {
        $lastProduction = DB::table('coal_productions')
                        ->select('coal_oven_id', DB::raw('MAX(round) as round'), DB::raw('MAX(id) as coal_production_id'))
                        ->groupBy('coal_oven_id');
        //return response()->json($lastProduction);
        $ovens = DB::Table('coal_ovens')
                        ->select('coal_ovens.id', 'coal_ovens.coal_unit_id', 'coal_units.unit', 'coal_ovens.ovens', 'coal_oven_types.type', 'round', 'coal_production_id')
                        ->leftJoinSub($lastProduction, 'productions', function ($join){
                            $join->on('coal_ovens.id', '=', 'productions.coal_oven_id');
                        })
                        ->leftJoin('coal_oven_types', 'oven_type_id', '=', 'coal_oven_types.id')
                        ->leftJoin('coal_units', 'coal_unit_id', '=', 'coal_units.id')
                        ->where('coal_unit_id', '=', $id)
                        ->get();
        $result = array();
        //return response()->json($ovens);
        foreach($ovens as $oven){
            $steps = DB::Table('coal_production_steps')
                        ->select('coal_production_steps.id', 'coal_production_steps.coal_production_id', 'coal_production_steps.dtinitial',
                                 'coal_production_steps.vol_wood', 'coal_production_steps.diameter_wood', 'coal_production_steps.coal_stock_id',
                                 'coal_production_steps.vol_charcoal', 'coal_production_steps.vol_atico', 'coal_steps.step', 'coal_steps.sequence')
                        ->leftJoin('coal_steps', 'coal_step_id', '=', 'coal_steps.id')
                        ->where('coal_production_id', '=', $oven->coal_production_id)
                        ->where('dtinitial', '!=', null)
                        ->orderByDesc('coal_steps.sequence')
                        ->limit($limit)
                        ->get();

            $resultSteps = array();

            foreach($steps as $step){
                $temperature = DB::Table('coal_temperatures')
                        ->select('coal_temperatures.coal_production_step_id', 'coal_temperatures.id', 'coal_temperatures.dtcollection','coal_temperatures.temperature', 'coal_temperatures.status')
                        ->leftJoin('coal_production_steps', 'coal_production_step_id', '=', 'coal_production_steps.id')
                        ->where('coal_production_steps.id', '=', $step->id)
                        ->orderByDesc('coal_temperatures.dtcollection')
                        ->limit($limit)
                        ->get();
                $resultSteps[] = ['step' => $step, 'temperatures' => $temperature];
            }
            $result[] = ['oven' => $oven, 'productions' => $resultSteps];
        }

        /*CoalOven::where('coal_unit_id', '=', $id)
                        ->with('ovenType', 'productions')
                        ->get();
        */
        return response()->json($result);
    }
}
