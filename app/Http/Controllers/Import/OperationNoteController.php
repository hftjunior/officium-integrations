<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\TmpHarvests;
use App\Models\OperationNote;
use App\Models\OperationNotesMoviment;
use App\Models\Operation;
use App\Models\IntRegion;
use App\Models\IntProject;
use App\Models\IntLocation;
use App\Models\IntStockLocation;

class OperationNoteController extends Controller
{
    public function import()
    {
        $operations = TmpHarvests::where('import', '=', 'N')->get();
        foreach($operations as $operation){
            $dtoperation = $operation->data_operacao;
            //$dtoperation = Date::excelToDateTimeObject($dtoperation)->format('Y-m-d');
            echo "dtoperation: ".$dtoperation." | ";

            $stmOperation = Operation::where('sgf_id', '=', $operation->id_operacao)->first();
            $operation_id = ($stmOperation) ? $stmOperation->id : 0;
            echo "OPERATIONID: ".$operation_id." | ";

            $stmRegion = IntRegion::where('sgf_id', '=', $operation->id_regiao)->first();
            $region_id = ($stmRegion) ? $stmRegion->id : 0;
            echo "REGIONID: ".$region_id." | ";

            $stmProject = IntProject::where('sgf_id', '=', $operation->id_projeto)->first();
            $project_id = ($stmProject) ? $stmProject->id : 0;
            echo "PROJECTID: ".$project_id." | ";

            $stmLocation = IntLocation::where('int_region_id', '=', $region_id)
                                    ->where('int_project_id', '=', $project_id)
                                    ->where('location', '=', $operation->talhao)
                                    ->first();
            $int_location_id = ($stmLocation) ? $stmLocation->id : 0;
            echo "LOCATION: ".$int_location_id." | ";

            $product_id = $operation->id_produto;
            echo "PRODUCTID: ".$product_id." | ";

            $product_descr = $operation->descr_produto;
            echo "PRODUCTINITIAL: ".$product_descr." | ";

            $stmStockLocation = IntStockLocation::where('int_location_id', '=', $int_location_id)
                                                ->where('status', '=', 'A')
                                                ->first();
            if($stmStockLocation){
                $person_related_id = $stmStockLocation->person_related_id;
                echo "PERSONRELATEDID: ".$person_related_id." | ";

                $int_stock_location = $stmStockLocation->id;
                echo "INTSTOCKLOCATIONID: ".$int_stock_location." | ";

                $result_center_id = $stmStockLocation->result_center_id;
                echo "RESULTCENTERID: ".$result_center_id." | ";
            }else {
                $person_related_id = 0;
                echo "PERSONRELATEDID: ".$person_related_id." | ";

                $int_stock_location = 0;
                echo "INTSTOCKLOCATIONID: ".$int_stock_location." | ";

                $result_center_id = 0;
                echo "RESULTCENTERID: ".$result_center_id." | ";
            }

            $qtde = $operation->volume_apontado;
            echo "QTDE: ".$qtde." | ";

            $sgf_id = $operation->id;
            echo "SGFID: ".$sgf_id."\n";

            if($stmOperation){
                foreach($stmOperation->moviments as $moviment){
                    echo "MOVIMENTO: ".$moviment->moviment->code. " | ";
                    echo "PRODUTO: ".$moviment->moviment->product_id. " | ";
                }
            }

            try{
                $operationNote = OperationNote::create([
                    "dtoperation" => $dtoperation,
                    "operation_id" => $operation_id,
                    "int_location_id" => $int_location_id,
                    "person_related_id" => $person_related_id,
                    "int_stock_location" => $int_stock_location,
                    "result_center_id" => $result_center_id,
                    "qtde" => number_format($qtde, 2,'.',''),
                    "sgf_id" => $sgf_id,
                ]);
                foreach($stmOperation->moviments as $moviment){
                    if(!empty($moviment->moviment->product_id)){
                        $operationNoteMoviment = OperationNotesMoviment::create([
                            "operation_notes_id" => $operationNote->id,
                            "int_moviment_type_id" => $moviment->moviment->id,
                            "product_id" => $moviment->moviment->product_id,
                            "integration" => "N",
                        ]);
                    }else{
                        foreach($stmOperation->products as $product){
                            $operationNoteMoviment = OperationNotesMoviment::create([
                                "operation_notes_id" => $operationNote->id,
                                "int_moviment_type_id" => $moviment->moviment->id,
                                "product_id" => $product->product->id,
                                "integration" => "N",
                            ]);
                        }
                    }
                }

                $updateTmpHarvests = TmpHarvests::find($sgf_id);
                $updateTmpHarvests->import = 'S';
                $updateTmpHarvests->save();

            }catch(\Illuminate\Database\QueryException $e){
                echo "Boletim: ".$sgf_id." não importado."."\n";
                continue;

            }catch(Exception $e){
                echo $e;
                continue;
            }
        }
    }
}
