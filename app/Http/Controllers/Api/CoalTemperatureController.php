<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CoalTemperature;
use App\Models\CoalProductionSteps;

class CoalTemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temperatures = CoalTemperature::all();
        return response()->json($temperatures);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(["coal_production_step_id", "coal_unit_id",
                               "coal_oven_id", "coal_temperature_point_id",
                               "dtcollection", "temperature", "status", "round"]);
        try{
            $productionStep = CoalProductionSteps::find($data["coal_production_step_id"]);
            if(empty($productionStep->dtinitial)){
                $productionStep->update(['dtinitial' => $data["dtcollection"]]);
            }
            $temperature = CoalTemperature::create($data);
        }catch(Illuminate\Database\QueryException $e){
            return result()->json(["message" => "Falha ao criar o registro"],404);
        }
        return $temperature;

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
