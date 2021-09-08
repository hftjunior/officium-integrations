<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\CoalProduction;
use App\Models\CoalStep;
use App\Models\CoalProductionSteps;

class CoalProductionRoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['coal_unit_id', 'coal_oven_id']);
        $actualRound = CoalProduction::select(DB::raw('MAX(round) as round'))
                                ->where('coal_oven_id', '=', $data['coal_oven_id'])
                                ->get();
        foreach($actualRound as $round){
            try{
                $data += ["round" => $round->round + 1];
                $insert = CoalProduction::create($data);
                $steps = CoalStep::orderBy('sequence')->get();
                $dataStep = array();

                foreach($steps as $step){
                    $dataStep = [
                        "coal_production_id" => $insert["id"],
                        "coal_step_id" => $step->id
                    ];
                    $insertSteps = CoalProductionSteps::create($dataStep);
                }

            }catch(Illuminate\Database\QueryException $e){
                return response()->json(["message" => "erro"], 404);
            }
        }
        return response()->json(["message" => "Novo ciclo criado"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
