<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Models\ImportInconsistency;
use App\Models\Person;
use App\Models\PersonEmployee;
use App\Models\Operation;
use App\Models\Product;
use App\Models\IntProject;
use App\Models\IntLocation;
use App\Models\PersonRelated;
use App\Models\ResultCenter;
use App\Models\ForestryNote;
use App\Models\ForestryNoteLocal;
use App\Models\ForestryNoteInput;
use App\Models\ForestryNoteStatus;
use App\Models\ForestryNoteDescard;

class TVForestryNotesController extends Controller
{
    public function soapTotvs($method, $params)
    {
        $link = env('WS_TV_QUERY_LINK');
        $options = array(
            'soap_version'  =>SOAP_1_1,
            'exceptions'    =>true,
            'trace'         =>1,
            'cache_wsdl'    =>WSDL_CACHE_DISK,
            'login'         => env('WS_TV_USER'),
            'password'      => env('WS_TV_PSWD')
        );

        $objSoaClient = new SoapClient($link, $options);
        $objResponse = $objSoaClient->__soapCall($method, array('parameters' => $params));
        return simplexml_load_string($objResponse->RealizarConsultaSQLResult);
    }



    public function getCroci()
    {
        $date = new \DateTime();
        //$dtapropriacao = $date->sub(new \DateInterval('P21D'));
        //$dtapropriacao = strtoupper($dtapropriacao->format('d/m/Y'));
        $dtapropriacao = '25/05/2021';
        $project = '%11201';

        $arrayParams = array(
            'codSentenca'   => 'wsSiCroci',
            'codColigada'   => '0',
            'codSistema'    => 'W',
            'parameters'    => 'codprj='.$project.';dtapropriacao='.$dtapropriacao
        );

        $datas = $this->soapTotvs('RealizarConsultaSQL', $arrayParams);

        $idCroci = 0;

        DB::table('import_inconsistencies')->where('application', '=', 'forestryNote')->where('user', '=', 'admin')->delete();

        foreach($datas as $key => $data)
        {
            //forestry_notes
            $check = $data->IDCROCI;
            if(intval($idCroci) != intval($check))
            {
                $idCroci = $data->IDCROCI;
                echo "IDCROCI: ".$idCroci;

                $smartquestion = $data->NUMATENDIMENTO;
                echo " | SMARTQUESTION: ".$smartquestion;

                $hrstart = substr($data->HRINICIOATV, 11, 8);
                //echo " | HSTART: ".$hrstart;
                $dtstart = substr($data->DTAPROPRIACAO, 0, 10)." ".$hrstart;
                //echo " | DTSTART: ".$dtstart;

                $date = new \DateTime($dtstart);
                $dtend = $date->add(new \DateInterval('PT8H48M'));
                //echo " | DTEND: ".$dtend->format('Y-m-d H:i:s');

                //$dtend = substr($data->DTAPROPRIACAO, 0, 10)." 16:48:00";
                //echo " | DTEND: ".$dtend;
                $related = PersonRelated::where('erp_code', '=', '2;62')->first();

                //$operation = Operation::where('code', '=', substr($data->CODTRF, -3, 3))->first();

                $operation = DB::table('operations')
                                ->join('operation_has_related', 'operations.id', '=', 'operation_has_related.operation_id')
                                ->where('operations.code', '=', substr($data->CODTRF, -3, 3))
                                ->where('operation_has_related.related_id', '=', $related->id)
                                ->select('operations.id')
                                ->first();
                if($operation)
                {
                    $operation_id = $operation->id;
                }
                else
                {
                    $operation_id = null;
                }

                echo " | OPERATION_ID: ".$operation_id;

                $person = Person::where('cpfcnpj', '=', $data->CPF)->first();
                if($person)
                {
                    $person_employee = PersonEmployee::where('people_id', '=', $person->id)->where('status', '=', 'A')->first();
                    if($person_employee)
                    {
                        $person_employee_id = $person_employee->id;
                    }
                    else
                    {
                        $person_employee_id = null;
                    }
                }
                else
                {
                    $person_employee_id = null;
                }

                //echo " | PERSON_EMPLOYEE_ID: ".$person_employee_id;

                $person_related = PersonRelated::where('cnpj','=', str_replace(array('.','/','-'), '', $data->CGC))->first();
                if($person_related)
                {
                    $person_related_id = $person_related->id;
                }
                else
                {
                    $person_related_id = null;
                }

                //echo " | PERSON_RELATED_ID: ".$person_related_id;

                $result_center = ResultCenter::where('code', '=', substr($data->CODPRJ, 5, 5))->first();
                if($result_center)
                {
                    $result_center_id = $result_center->id;
                }
                else
                {
                    $result_center_id = null;
                }
                //echo " | RESULT_CENTER_ID: ".$result_center_id;

                $status = ForestryNoteStatus::where('status', '=', 'EM ANÁLISE')->first();
                if($status)
                {
                    $statusId = $status->id;
                }
                else
                {
                    $statusId = null;
                }
                echo " | STATUS: ".$statusId;

                $dataInsertForestyNote = [
                    "dtstart"               => $dtstart,
                    "dtend"                 => $dtend,
                    "operation_id"          => $operation_id,
                    "person_employee_id"    => $person_employee_id,
                    "person_related_id"     => $person_related_id,
                    "result_center_id"      => $result_center_id,
                    "smartquestion"         => $smartquestion,
                    "forestry_note_status_id" => $statusId,
                    "croci"                 => $idCroci,
                    "created_at"            => date('Y-m-d H:i:s'),
                    "updated_at"            => date('Y-m-d H:i:s')
                ];
                $forestryNote = ForestryNote::where('smartquestion', '=', $smartquestion)->first();
                if($forestryNote)
                {
                    try
                    {
                        $forestryNote->dtstart = $dtstart;
                        $forestryNote->dtend = $dtend;
                        $forestryNote->operation_id = $operation_id;
                        $forestryNote->person_employee_id = $person_employee_id;
                        $forestryNote->person_related_id = $person_related_id;
                        $forestryNote->result_center_id = $result_center_id;
                        $forestryNote->smartquestion = $smartquestion;
                        $forestryNote->forestry_note_status_id = $statusId;
                        $forestryNote->croci = $idCroci;
                        $forestryNote->updated_at = date('Y-m-d H:i:s');
                        $forestryNote->save();
                        $forestry_note_id = $forestryNote->id;
                        echo " | FORESTRY NOTE ID: ".$forestry_note_id;
                    }
                    catch (\Exception $e)
                    {
                        $dataInsertInconsistency = [
                            'user'          => 'admin',
                            'application'   => 'forestryNote',
                            'spreadsheet'   => 'WS',
                            'description'   => $e->getMessage(),
                            'line'          => $idCroci,
                            'created_at'    => date('Y-m-d H:i:s')
                        ];
                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                        /*
                        echo "IDCROCI: ".$idCroci;
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        */
                        continue;
                    }
                }
                else
                {
                    try
                    {
                        $forestry = ForestryNote::create($dataInsertForestyNote);
                        $forestry_note_id = $forestry->id;
                        echo " | FORESTRY NOTE ID: ".$forestry_note_id;
                    }
                    catch (\Exception $e)
                    {
                        $dataInsertInconsistency = [
                            'user'          => 'admin',
                            'application'   => 'forestryNote',
                            'spreadsheet'   => 'WS',
                            'description'   => $e->getMessage(),
                            'line'          => $idCroci,
                            'created_at'    => date('Y-m-d H:i:s')
                        ];
                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);

                        /*
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        */
                        continue;
                    }
                }

                //forestry_note_locals
                echo " | FORESTRY_NOTE_ID: ".$forestry_note_id;
                echo " | PROJETO: ".preg_replace('/\s+/', '', $data->DESCRICAO);
                $project = IntProject::where('project', '=', preg_replace('/\s+/', '', $data->DESCRICAO))->first();

                if($project)
                {
                    echo " | TALHAO: ".$data->CODTALHAO;
                    $location = IntLocation::where('location', '=', $data->CODTALHAO)->where('int_project_id', '=', $project->id)->first();
                    if($location)
                    {
                        $int_location_id = $location->id;
                    }
                    else
                    {
                        $int_location_id = null;
                    }
                }
                else
                {
                    $int_location_id = null;
                }
                //echo " | INT_LOCATION_ID: ".$int_location_id;

                $haAmount = number_format(floatval($data->HAEXECUTADO), 3, '.', '');
                //echo " | AMOUNT: ".$haAmount;

                $close = $data->TALHAOFECHADO;
                //echo " | OPEN: ".$close;
                if($close == 'S')
                {
                    $uniqid = uniqid();
                }
                else
                {
                    $uniqid = null;
                }

                $rework = $data->RETRABALHO;
                //echo " | REWORD: ".$rework;

                $dataInserForestryNoteLocals = [
                    "forestry_note_id"  => $forestry_note_id,
                    "int_location_id"   => $int_location_id,
                    "amount"            => $haAmount,
                    "close"              => $close,
                    "rework"            => $rework,
                    "reapplication"     => 'N',
                    "uniqid"            => $uniqid,
                    "idcroci"           => $idCroci,
                    "created_at"        => date('Y-m-d H:i:s'),
                    "updated_at"        => date('Y-m-d H:i:s')
                ];

                $forestryNoteLocal = ForestryNoteLocal::where('forestry_note_id', '=', $forestry_note_id)
                                                      ->where('int_location_id', '=', $int_location_id)->first();
                if($forestryNoteLocal)
                {
                    try
                    {
                        $forestryNoteLocal->forestry_note_id = $forestry_note_id;
                        $forestryNoteLocal->int_location_id = $int_location_id;
                        $forestryNoteLocal->amount = $haAmount;
                        $forestryNoteLocal->close = $close;
                        $forestryNoteLocal->rework = $rework;
                        $forestryNoteLocal->reapplication = 'N';
                        $forestryNoteLocal->idcroci = $idCroci;
                        $forestryNoteLocal->updated_at = date('Y-m-d H:i:s');
                        $forestryNoteLocal->save();
                    }
                    catch (\Exception $e)
                    {
                        $dataInsertInconsistency = [
                            'user'          => 'admin',
                            'application'   => 'forestryNote',
                            'spreadsheet'   => 'WS',
                            'description'   => $e->getMessage(),
                            'line'          => $idCroci,
                            'created_at'    => date('Y-m-d H:i:s')
                        ];
                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);

                        /*
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        */
                        continue;
                    }
                }
                else
                {
                    try
                    {
                        $forestryNoteLocalData = ForestryNoteLocal::create($dataInserForestryNoteLocals);
                    }
                    catch (\Exception $e)
                    {
                        $dataInsertInconsistency = [
                            'user'          => 'admin',
                            'application'   => 'forestryNote',
                            'spreadsheet'   => 'WS',
                            'description'   => $e->getMessage(),
                            'line'          => $idCroci,
                            'created_at'    => date('Y-m-d H:i:s')
                        ];
                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);

                        /*
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        */
                        continue;
                    }
                }

                if($close == 'S')
                {
                    $closedLocals = DB::select('select forestry_note_locals.id as id
                                                from forestry_notes, forestry_note_locals
                                                where forestry_note_locals.forestry_note_id = forestry_notes.id
                                                and forestry_note_locals.int_location_id = '.$int_location_id.'
                                                and forestry_notes.operation_id = '.$operation_id.'
                                                and forestry_note_locals.uniqid is null
                                                order by forestry_notes.dtstart');
                    if($closedLocals)
                    {
                        foreach($closedLocals as $local)
                        {
                            $forestryNoteLocalsClosed = ForestryNoteLocal::find($local->id);
                            $forestryNoteLocalsClosed->uniqid = $uniqid;
                            $forestryNoteLocalsClosed->close = 'S';
                            $forestryNoteLocalsClosed->save();
                        }
                    }
                }
                echo "\n";
            }

            // forestry_notes_inputs
            //$product = Product::where('product', 'like', '%'.preg_replace('/\s+/', '', $data->INSUMO_CLIENTE).'%')->first();
            $product = Product::where('erp_code', '=', $data->CODISM)->first();
            if($product)
            {
                $product_id = $product->id;
                $measure = $product->measure->initial;
            }
            else
            {
                $product_id = preg_replace('/\s+/', '', $data->INSUMO_CLIENTE);
                $measure = null;
            }
            echo " | PRODUCT_ID: ".$product_id;

            $amount = number_format(floatval($data->QTDEUTILIZADA), 3, '.', '');
            //$amount = $data->QTDEUTILIZADA;
            echo " | AMOUNT: ".$amount;

            //echo " | MEASURE: ".$measure;

            $idcrociinsumo = $data->IDCROCIINSUMO;
            echo " | IDCROCIINSUMO: ".$idcrociinsumo;


            $dataInsertForestyNoteInputs = [
                "forestry_note_id"  => $forestry_note_id,
                "product_id"        => $product_id,
                "amount"            => $amount,
                "measure"           => $measure,
                "idcrociinsumo"     => $idcrociinsumo,
                "created_at"        => date('Y-m-d H:i:s')
            ];

            $forestryNoteInput = ForestryNoteInput::where('forestry_note_id', '=', $forestry_note_id)
                                                  ->where('product_id', '=', $product_id)
                                                  ->where('idcrociinsumo', '=', $idcrociinsumo)
                                                  ->first();
            if($forestryNoteInput)
            {
                try
                {
                    $forestryNoteInput->forestry_note_id = $forestry_note_id;
                    $forestryNoteInput->product_id = $product_id;
                    $forestryNoteInput->amount = $amount;
                    $forestryNoteInput->measure = $measure;
                    $forestryNoteInput->idcrociinsumo = $idcrociinsumo;
                    $forestryNoteInput->updated_at = date('Y-m-d H:i:s');
                    $forestryNoteInput->save();
                }
                catch (\Exception $e)
                {
                    $dataInsertInconsistency = [
                        'user'          => 'admin',
                        'application'   => 'forestryNote',
                        'spreadsheet'   => 'WS',
                        'description'   => $e->getMessage(),
                        'line'          => $idCroci,
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                    $inconsistency = ImportInconsistency::create($dataInsertInconsistency);

                    /*
                    echo "\n";
                    echo "| ERROR | ".$e->getMessage();
                    echo "\n";
                    */
                    continue;
                }

            }
            else
            {
                try
                {
                    $forestryNoteInputData = ForestryNoteInput::create($dataInsertForestyNoteInputs);
                }
                catch (\Exception $e)
                {
                    $dataInsertInconsistency = [
                        'user'          => 'admin',
                        'application'   => 'forestryNote',
                        'spreadsheet'   => 'WS',
                        'description'   => $e->getMessage(),
                        'line'          => $idCroci,
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                    $inconsistency = ImportInconsistency::create($dataInsertInconsistency);

                    /*
                    echo "\n";
                    echo "| ERROR | ".$e->getMessage();
                    echo "\n";
                    */
                    continue;
                }
            }
            echo "\n";
        }
    }

    public function getCrociDiscard()
    {
        $date = new \DateTime();
        //$dtapropriacao = $date->sub(new \DateInterval('P21D'));
        //$dtapropriacao = strtoupper($dtapropriacao->format('d/m/Y'));
        $dtapropriacao = '26/05/2021';
        $project = '%11201';

        $arrayParams = array(
            'codSentenca'   => 'wsSiCrociMudas',
            'codColigada'   => '0',
            'codSistema'    => 'W',
            'parameters'    => 'data='.$dtapropriacao.';codprj='.$project
        );

        $datas = $this->soapTotvs('RealizarConsultaSQL', $arrayParams);

        $idCroci = 0;

        DB::table('import_inconsistencies')->where('application', '=', 'forestryNoteDiscard')->where('user', '=', 'admin')->delete();

        foreach($datas as $key => $data)
        {
            //forestry_notes
            $check = $data->IDCROCI;
            if(intval($idCroci) != intval($check))
            {
                $idCroci = $data->IDCROCI;
                echo "IDCROCI: ".$idCroci;

                $idCrociMudas = $data->IDCROCIMUDAS;
                echo " | ".$idCrociMudas;

                $forestryNote = ForestryNote::where('smartquestion', '=', $data->NUMATENDIMENTO)->first();
                if($forestryNote)
                {
                    $forestry_note_id = $forestryNote->id;
                    echo " | FORESTRY_ID: ".$forestry_note_id;

                    $product = Product::where('erp_code', '=', $data->CODISM)->first();
                    if($product)
                    {
                        $product_id = $product->id;
                        $measure = $product->measure->initial;
                    }
                    else
                    {
                        $product_id = null;
                        $measure = null;
                    }
                    echo " | PRODUCT_ID: ".$product_id;
                    //echo " | MEASURE: ".$measure;

                    if($data->NUMLOTE)
                    {
                        $part = $data->NUMLOTE;
                    }
                    else
                    {
                        $part = null;
                    }
                    //echo " | PART: ".$part;

                    if($data->NUMEXP)
                    {
                        $expedition = $data->NUMEXP;
                    }
                    else
                    {
                        $expedition = null;
                    }
                    //echo " | EXPEDITION: ".$expedition;

                    if($data->QTDERECEBIDA)
                    {
                        $amount_received = number_format(floatval($data->QTDERECEBIDA), 3, '.', '');
                    }
                    else
                    {
                        $amount_received = 0;
                    }
                    //echo " | AMOUNT_RECEIVED: ".$amount_received;

                    if($data->QTDEPLANTADA)
                    {
                        $amount_planted = number_format(floatval($data->QTDEPLANTADA), 3, '.', '');
                    }
                    else
                    {
                        $amount_planted = 0;
                    }
                    //echo " | AMOUNT_PLANTED: ".$amount_planted;

                    if($data->NUMDESCSUB)
                    {
                        $amount_desc_sub = number_format(floatval($data->NUMDESCSUB), 3, '.', '');
                    }
                    else
                    {
                        $amount_desc_sub = 0;
                    }
                    //echo " | AMOUNT_DESC_SUB: ".$amount_desc_sub;

                    if($data->NUMDESCQUE)
                    {
                        $amount_desc_broken = number_format(floatval($data->NUMDESCQUE), 3, '.', '');
                    }
                    else
                    {
                        $amount_desc_broken = 0;
                    }
                    //echo " | AMOUNT_DESC_BROKEN: ".$amount_desc_broken;

                    if($data->NUMDESCVER)
                    {
                        $amount_desc_green = number_format(floatval($data->NUMDESCVER), 3, '.', '');
                    }
                    else
                    {
                        $amount_desc_green = 0;
                    }
                    //echo " | AMOUNT_DESC_GREEN: ".$amount_desc_green;

                    if($data->NUMDESCDOE)
                    {
                        $amount_desc_disease = number_format(floatval($data->NUMDESCDOE), 3, '.', '');
                    }
                    else
                    {
                        $amount_desc_disease = 0;
                    }
                    //echo " | AMOUNT_DESC_DISEASE: ".$amount_desc_disease;

                    if($data->NUMDESCTOT)
                    {
                        $amount_desc_total = number_format(floatval($data->NUMDESCTOT), 3, '.', '');
                    }
                    else
                    {
                        $amount_desc_total = 0;
                    }
                    //echo " | AMOUNT_DESC_TOTAL: ".$amount_desc_total;

                    if($data->PERDESCTOT)
                    {
                        $perc_desc_total = number_format(floatval($data->PERDESCTOT), 3, '.', '');
                    }
                    else
                    {
                        $perc_desc_total = 0;
                    }
                    //echo " | PERC_DESC_TOTAL: ".$perc_desc_total;

                    echo "\n";
                    $forestryNoteDiscard = ForestryNoteDescard::where('product_id', '=', $product_id)
                                                              ->where('forestry_note_id', '=', $forestry_note_id)->first();

                    if($forestryNoteDiscard)
                    {
                        try
                        {
                            $forestryNoteDiscard->measure = $measure;
                            $forestryNoteDiscard->part = $part;
                            $forestryNoteDiscard->expedition = $expedition;
                            $forestryNoteDiscard->amount_received = $amount_received;
                            $forestryNoteDiscard->amount_planted = $amount_planted;
                            $forestryNoteDiscard->amount_desc_sub = $amount_desc_sub;
                            $forestryNoteDiscard->amount_desc_broken = $amount_desc_broken;
                            $forestryNoteDiscard->amount_desc_green = $amount_desc_green;
                            $forestryNoteDiscard->amount_desc_disease = $amount_desc_disease;
                            $forestryNoteDiscard->amount_desc_total = $amount_desc_total;
                            $forestryNoteDiscard->perc_desc_total = $perc_desc_total;
                            $forestryNoteDiscard->idcrocimudas = $idCrociMudas;
                            $forestryNoteDiscard->updated_at = date('Y-m-d H:i:s');
                            $forestryNoteDiscard->save();
                        }
                        catch (\Exception $e)
                        {
                            $dataInsertInconsistency = [
                                'user'          => 'admin',
                                'application'   => 'forestryNoteDiscard',
                                'spreadsheet'   => 'WS',
                                'description'   => $e->getMessage(),
                                'line'          => $idCroci,
                                'created_at'    => date('Y-m-d H:i:s')
                            ];
                            $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                            continue;
                        }
                    }
                    else
                    {
                        try
                        {
                            $dataInsertForestryNoteDiscard = [
                                "forestry_note_id"      => $forestry_note_id,
                                "product_id"            => $product_id,
                                "measure"               => $measure,
                                "part"                  => $part,
                                "expedition"            => $expedition,
                                "amount_received"       => $amount_received,
                                "amount_planted"        => $amount_planted,
                                "amount_desc_sub"       => $amount_desc_sub,
                                "amount_desc_broken"    => $amount_desc_broken,
                                "amount_desc_green"     => $amount_desc_green,
                                "amount_desc_disease"   => $amount_desc_disease,
                                "amount_desc_total"     => $amount_desc_total,
                                "perc_desc_total"       => $perc_desc_total,
                                "idcrocimudas"          => $idCrociMudas,
                                "created_at"            => date('Y-m-d H:i:s')
                            ];
                            //var_dump($dataInsertForestryNoteDiscard);
                            $insertForestryNoteDiscart = ForestryNoteDescard::create($dataInsertForestryNoteDiscard);

                        }
                        catch (\Exception $e)
                        {
                            $dataInsertInconsistency = [
                                'user'          => 'admin',
                                'application'   => 'forestryNoteDiscard',
                                'spreadsheet'   => 'WS',
                                'description'   => $e->getMessage(),
                                'line'          => $idCroci,
                                'created_at'    => date('Y-m-d H:i:s')
                            ];
                            $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                            continue;
                        }
                    }
                }
                else
                {

                }
            }
            echo "\n";
        }
    }
}
