<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Models\IntRegion;
use App\Models\IntProject;
use App\Models\IntLocation;
use App\Models\TmpRegistration;

class SFRegistrationController extends Controller
{
    public function updateRegistrations()
    {
        $locations = IntLocation::where('own', '=', 'S')->get();
        foreach($locations as $location)
        {
            $sfRegion = $location->region->sgf_id;
            echo "REGION: ".$sfRegion;

            $sfProject = $location->project->sgf_id;
            echo " | PROJECT: ".$sfProject;

            $sfLocal = $location->sf_id;
            echo " | LOCATION: ".$sfLocal;

            $tmpRegistration = TmpRegistration::where('id_regiao', '=', $sfRegion)
                                              ->where('id_projeto', '=', $sfProject)
                                              ->where('sf_id', '=', $sfLocal)->first();
            if($tmpRegistration)
            {
                try
                {
                    echo " | AREA_GIS: ".$tmpRegistration->area_gis;
                    echo " | ATIVO: ".$tmpRegistration->ativo;
                    $location->area = $tmpRegistration->area_gis;
                    $location->active = $tmpRegistration->ativo;
                    $location->own = "S";
                    $location->sf_id = $tmpRegistration->sf_id;
                    $location->updated_at = date('Y-m-d H:i:s');
                    $location->save();
                }
                catch (\Exception $e)
                {
                    echo "\n";
                    echo "| ERROR | ".$e->getMessage();
                    echo "\n";
                    continue;
                }

            }
            echo "\n";
        }

    }

    public function createdRegistrations()
    {
        $tmpRegistrations = TmpRegistration::all();
        foreach ($tmpRegistrations as $key => $tmpRegistration) {
            $region = IntRegion::where('sgf_id', '=', $tmpRegistration->id_regiao)->first();

            if($region)
            {
                $project = IntProject::where('sgf_id', '=', $tmpRegistration->id_projeto)->first();
                if($project)
                {
                    $local = IntLocation::where('int_region_id', '=', $region->id)
                                        ->where('int_project_id', '=', $project->id)
                                        ->where('location', '=', $tmpRegistration->talhao)->first();
                    if(!$local)
                    {
                        $dataCreateLocal = [
                            "int_region_id" => $region->id,
                            "int_project_id" => $project->id,
                            "location" => $tmpRegistration->talhao,
                            "area" => ($tmpRegistration->area_gis) ? $tmpRegistration->area_gis : 0,
                            "active" => $tmpRegistration->ativo,
                            "own" => 'S',
                            "sf_id" => $tmpRegistration->sf_id,
                            "created_at" => date('Y-m-d H:i:s')
                        ];
                        try
                        {
                            var_dump($dataCreateLocal);
                            echo "\n";
                            $createLocal = IntLocation::create($dataCreateLocal);
                        }
                        catch (\Exception $e)
                        {
                            echo "\n";
                            echo "| ERROR | ".$e->getMessage();
                            echo "\n";
                            continue;
                        }
                    }
                    else
                    {
                        $local->area = ($tmpRegistration->area_gis) ? $tmpRegistration->area_gis : 0;
                        $local->active = $tmpRegistration->ativo;
                        $local->own = "S";
                        $local->sf_id = $tmpRegistration->sf_id;
                        $local->updated_at = date('Y-m-d H:i:s');
                        $local->save();
                    }
                }
            }
        }
    }
}
