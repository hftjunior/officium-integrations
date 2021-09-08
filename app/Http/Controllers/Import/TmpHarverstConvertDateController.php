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

class TmpHarverstConvertDateController extends Controller
{
    public function convert()
    {
        $operations = TmpHarvests::all();
        foreach($operations as $operation){
            try{
                $updateTmpHarvests = TmpHarvests::find($operation->id);
                $updateTmpHarvests->data_cto = ($operation->data_cto) ? Date::excelToDateTimeObject($operation->data_cto)->format('Y-m-d') : null;
                $updateTmpHarvests->data_operacao = ($operation->data_operacao) ? Date::excelToDateTimeObject($operation->data_operacao)->format('Y-m-d') : null;
                $updateTmpHarvests->data_hora_inicio = ($operation->data_hora_inicio) ? Date::excelToDateTimeObject($operation->data_hora_inicio)->format('Y-m-d H:i:s') : null;
                $updateTmpHarvests->incio_fim = ($operation->incio_fim) ? Date::excelToDateTimeObject($operation->incio_fim)->format('Y-m-d H:i:s') : null;
                $updateTmpHarvests->data_registro = ($operation->data_registro) ? Date::excelToDateTimeObject($operation->data_registro)->format('Y-m-d') : null;
                $updateTmpHarvests->save();
            }catch(\Illuminate\Database\QueryException $e){
                echo "Boletim: ".$operation->id." não convertido."."\n";
                continue;

            }catch(Exception $e){
                echo $e;
                continue;
            }
        }
    }
}
