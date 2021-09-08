<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Objects;
use App\Models\ObjectCodeAgency;
use App\Models\ObjectAgency;
use App\Models\PersonRelated;
use App\Models\PersonEmployee;
use App\Models\PersonProvider;
use App\Models\PersonDocument;
use App\Models\PersonDocumentType;
use App\Models\ResultCenter;
use App\Models\Operation;
use App\Models\Product;
use App\Models\CoalUnit;
use App\Models\CoalStock;
use App\Models\Person;
use App\Models\LogIntegration;
use App\Models\Notification;
use App\Models\CoalExpedition;
use App\Models\CoalOrder;
use App\Models\CoalMeasure;
use App\Models\ForestryNoteStatus;
use App\Models\ForestryNote;
use App\Models\ForestryNoteManpower;
use App\Models\ForestryNoteLocal;
use App\Models\ForestryNoteObject;
use App\Models\ForestryNoteInput;
use App\Models\ForestryNoteDescard;
use App\Models\ForestryManpowerType;
use App\Models\ForestryCause;
use App\Models\IntRegion;
use App\Models\IntProject;
use App\Models\IntLocation;
use App\Models\ImportInconsistency;

class SQForestryNoteController extends Controller
{
    public function soapSmartQuestion($method, $params){
        $link = env('WS_SQLINK');
        $options = array(
            'soap_version'=>SOAP_1_1,
            'exceptions'=>true,
            'trace'=>1,
            'cache_wsdl'=>WSDL_CACHE_DISK
        );

        $objSoaClient = new SoapClient($link, $options);
        $objResponse = $objSoaClient->__soapCall($method, array('parameters' => $params));
        return $objResponse->return;

    }

    public function convertDate($dtt){
        $dt = substr($dtt, 0, 10);
        return $dt;

    }

    public function convertHours($hour){
        $hr = str_pad((int)($hour/3600),2,'0',STR_PAD_LEFT);
        $min = str_pad((int)(($hour%3600)/60),2,'0',STR_PAD_LEFT);

        return $hr.":".$min.":00";
    }

    public function consultDatabase($table, $column, $value, $column2, $value2){
        if($table == "products"){
            $consult = Product::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Product::where($column, "=", $value)->first());
        }
        if($table == "forestry_causes"){
            $consult = ForestryCause::where($column, "=", (int) $value)->doesntExist();
            return ($consult) ? null : (ForestryCause::where($column, "=", (int) $value)->first());
        }
        if($table == "forestry_manpower_types"){
            $consult = ForestryManpowerType::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (ForestryManpowerType::where($column, "=", $value)->first());
        }
        if($table == "forestry_note_statueses"){
            $consult = ForestryNoteStatus::where($column, "=", "EM ANALISE")->doesntExist();
            return ($consult) ? null : (ForestryNoteStatus::where($column, "=", "EM ANALISE")->first());
        }
        if($table == "objects"){
            $consult = Objects::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Objects::where($column, "=", $value)->first());
        }
        if($table == "person_related"){
            $consult = PersonRelated::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (PersonRelated::where($column, "=", $value)->first());
		}
        if($table == "person_employees"){
            $consult = PersonEmployee::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (PersonEmployee::where($column, "=", $value)->first());
		}
		if($table == "person_providers"){
            $consult = PersonProvider::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (PersonProvider::where($column, "=", $value)->first());
        }
        if($table == "result_centers"){
            $consult = ResultCenter::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (ResultCenter::where($column, "=", $value)->first());
		}
		if($table == "operations"){
            $consult = Operation::where($column, "=", $value)->doesntExist();
            $operation = DB::table('operations')
                         ->join('operation_has_related', 'operations.id', '=', 'operation_has_related.operation_id')
                         ->where('operations.code', '=', $value)
                         ->where('operation_has_related.related_id', '=', $value2)->first();
            return ($consult) ? null : $operation;
		}
        if($table == "int_locations"){
            $consult = IntLocation::where($column, "=", $value)->doesntExist();
            $location = DB::table('int_locations')
                         ->join('int_projects', 'int_locations.int_project_id', '=', 'int_projects.id')
                         ->join('int_regions', 'int_locations.int_region_id', '=', 'int_regions.id')
                         ->where('int_locations.location', '=', $value)
                         ->where('int_projects.project', '=', $value2)
                         ->select('int_locations.id')->first();
            return ($consult) ? null : $location;
		}
		if($table == "coal_units"){
            $consult = CoalUnit::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (CoalUnit::where($column, "=", $value)->first());
        }
        if($table == "coal_stocks"){
            $consult = CoalStock::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (CoalStock::where($column, "=", $value)->where("type", "=", "C")->first());
		}
		if($table == "people"){
            $consult = Person::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Person::where($column, "=", $value)->first());
        }
        if($table == "coal_order"){
            $consult = CoalOrder::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (CoalOrder::where($column, "=", $value)->where($column2, "=", $value2)->where("status", "=", "A")->first());
        }
        if($table == "coal_measures"){
            $consult = CoalMeasure::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (CoalMeasure::whereRaw("BINARY ".$column." = ?", $value)->first());
        }

        if($table == "object_code_agency"){
            $consult = ObjectCodeAgency::where($column, "=", $value)->doesntExist();
            $agency = ObjectAgency::where("agency", "=", "ANTT")->first();
            return ($consult) ? null : (ObjectCodeAgency::where($column, "=", $value)
                                                        ->where("object_agency_id", "=", $agency->id)
                                                        ->first());
        }

        if($table == "documents"){
            $consult = PersonDocument::where($column, "=", $value)->doesntExist();
            $document = PersonDocumentType::where("type", "=", "CNH")->first();
            return ($consult) ? null : (PersonDocument::where($column, "=", $value)
                                                        ->where("document_type_id", "=", $document->id)
                                                        ->first());
        }

        if($table == "antt"){
            $consult = PersonDocument::where($column, "=", $value)->doesntExist();
            $document = PersonDocumentType::where("type", "=", "ANTT")->first();
            return ($consult) ? null : (PersonDocument::where($column, "=", $value)
                                                        ->where("document_type_id", "=", $document->id)
                                                        ->first());
        }
    }

    public function forestryNote(){
        DB::table('import_inconsistencies')->where('application', '=', 'forestryNote')->where('user', '=', 'admin')->delete();
        try{
            $date = new \DateTime();
            $dtinitial = $date;
            $dtinitial = strtoupper($dtinitial->format('Y-m-d'));
            $dtend = $date->add(new \DateInterval('P1D'));
            $dtend = strtoupper($dtend->format('Y-m-d'));

            $arrayParams = array(
                "login" => env('WS_SQUSER'),
                "senha" => env('WS_SQPSWD'),
                "dataInicial" => '2021-08-24',
                "dataFinal" => '2021-08-25'
            );
            $data = $this->soapSmartQuestion('getAtendimentosPeriodo', $arrayParams);

            $contForm = 0;
            $contInsert = 0;
            $expedition = array();

            for($i=0; $i<count($data); $i++){
                $form = $data[$i]->tipoVisita->codigo;
                if($form == "GP_CROCI"){
                    //print_r($data[$i]);
                    $contForm ++;
                    $person_related = $data[$i]->pontoAtendimento->unidadeAtendimento->oid;
                    //echo "PERSON RELATED: ".$person_related." | \n";
                    $smartquestion = $data[$i]->numeroAtendimento;
                    //echo "SMARTQUESTION: ".$smartquestion." | \n";
                    $person_employee = str_replace('-', '', $data[$i]->usuario->codigo);
                    //$person_employee = str_replace('-', '', '273-00270');
                    //echo "EMPLOYEE:".$person_employee." | \n";

                    $dtstart = null;
                    $hrstart = null;
                    $dtend = null;
                    $hrend = null;
                    $note = null;
                    $operation = null;
                    $person_employee_id = null;
                    $person_related_id = null;
                    $result_center = null;
                    $forestry_note_status_id = null;
                    $forestry_note_period_id = null;
                    $manpowers = [];
                    $locals = [];
                    $objects = [];
                    $inputs = [];
                    $discards = [];

                    foreach($data[$i]->listaResposta as $key => $resposta){
                        foreach($resposta->listaCampoResposta as $resposta_2)
                        {
                            /** field list */
                            if($resposta_2->campoFormulario->codigo == "GP_CROCI_OBS"){
                                if(isset($resposta_2->valorRespostaTexto)){
                                    $note = $resposta_2->valorRespostaTexto;
                                    //echo "NOTE: ".$note." | \n";
                                }
                            }

                            /** field list */
                            if($resposta_2->campoFormulario->codigo == "GP_CRO_CR"){
                                if(isset($resposta_2->valorRespostaEnumeracao)){
                                    $result_center = $resposta_2->valorRespostaEnumeracao->codigo;
                                    //echo "RESULT_CENTER: ".$result_center." | \n";
                                }
                            }

                            if($resposta_2->campoFormulario->codigo == "GP_CRO_OPERACAO"){
                                if(isset($resposta_2->valorRespostaEnumeracao)){
                                    $operation = $resposta_2->valorRespostaEnumeracao->codigo;
                                    //echo "OPERATION: ".$operation." | \n";
                                }
                            }

                            /** field date */
                            if($resposta_2->campoFormulario->codigo == "GP_CRO_DTINICIO"){
                                if(isset($resposta_2->valorRespostaData)){
                                    $dtstart = $this->convertDate($resposta_2->valorRespostaData);
                                    //echo "DTSTART: ".$dtstart." | \n";
                                }
                            }
                            if($resposta_2->campoFormulario->codigo == "GP_CROCI_DTFIM"){
                                if(isset($resposta_2->valorRespostaData)){
                                    $dtend = $this->convertDate($resposta_2->valorRespostaData);
                                    //echo "DTFIM: ".$dtend." | \n";
                                }
                            }

                            /** field hour */
                            if($resposta_2->campoFormulario->codigo == "GP_CRO_HRINICIO"){
                                if(isset($resposta_2->valorRespostaHora)){
                                    $hrstart = $this->convertHours($resposta_2->valorRespostaHora);
                                    //echo "HRSTART: ".$hrstart." | \n";
                                }
                            }
                            if($resposta_2->campoFormulario->codigo == "GP_CROCI_HRFIM"){
                                if(isset($resposta_2->valorRespostaHora)){
                                    $hrend = $this->convertHours($resposta_2->valorRespostaHora);
                                    //echo "HREND: ".$hrend." | \n";
                                }
                            }

                            /** field form */
                            if($resposta_2->campoFormulario->codigo == "GP_FORM_LOCAIS"){
                                if(isset($resposta_2->respostaFormulario)){
                                    foreach($resposta_2->respostaFormulario->listaCampoResposta as $respostaForm)
                                    {
                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_PROJETO")
                                        {
                                            if(isset($respostaForm->valorRespostaTexto))
                                            {
                                                $projeto = $respostaForm->valorRespostaTexto;
                                            }
                                            else
                                            {
                                                $projeto = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_TALHAO")
                                        {
                                            if(isset($respostaForm->valorRespostaTexto))
                                            {
                                                $talhao = $respostaForm->valorRespostaTexto;
                                            }
                                            else
                                            {
                                                $talhao = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_OBS")
                                        {
                                            if(isset($respostaForm->valorRespostaTexto))
                                            {
                                                $obs = $respostaForm->valorRespostaTexto;
                                            }
                                            else
                                            {
                                                $obs = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_QTDE")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde = number_format($respostaForm->valorRespostaNumerico, 2, '.','');
                                            }
                                            else
                                            {
                                                $qtde = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_REAPLIC")
                                        {
                                            if(isset($respostaForm->valorRespostaBooleano))
                                            {
                                                $reaplicacao = $respostaForm->valorRespostaBooleano;
                                            }
                                            else
                                            {
                                                $reaplicacao = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_RETRAB")
                                        {
                                            if(isset($respostaForm->valorRespostaBooleano))
                                            {
                                                $retrabalho = $respostaForm->valorRespostaBooleano;
                                            }
                                            else
                                            {
                                                $retrabalho = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_FECHADO")
                                        {
                                            if(isset($respostaForm->valorRespostaBooleano))
                                            {
                                                $fechado = $respostaForm->valorRespostaBooleano;
                                            }
                                            else
                                            {
                                                $fechado = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROL_REAPLI_CAUSA")
                                        {
                                            if(isset($respostaForm->valorRespostaEnumeracao))
                                            {
                                                $causa = $respostaForm->valorRespostaEnumeracao->codigo;
                                            }
                                            else
                                            {
                                                $causa = null;
                                            }
                                        }
                                    }
                                    array_push($locals, [
                                        "projeto" => strtoupper($projeto),
                                        "talhao" => strtoupper($talhao),
                                        "qtde" => $qtde,
                                        "reaplicacao" => $reaplicacao,
                                        "retrabalho" => $retrabalho,
                                        "fechado" => $fechado,
                                        "causa" => $causa,
                                        "obs" => $obs
                                    ]);
                                }
                            }

                            /** field form */
                            if($resposta_2->campoFormulario->codigo == "GP_FORM_OBJETO"){
                                if(isset($resposta_2->respostaFormulario)){
                                    if($resposta_2->respostaFormulario->listaCampoResposta->campoFormulario->codigo == "GP_CROO_OBJETO")
                                    {
                                        if(isset($resposta_2->respostaFormulario->listaCampoResposta->valorRespostaEnumeracao))
                                        {
                                            $objeto = $resposta_2->respostaFormulario->listaCampoResposta->valorRespostaEnumeracao->codigo;
                                        }
                                        else
                                        {
                                            $objeto = null;
                                        }
                                    }
                                    array_push($objects, [
                                        "objeto"  => $objeto
                                    ]);
                                }
                            }
                            /** field form */
                            if($resposta_2->campoFormulario->codigo == "GP_FORM_MAOOBRA"){
                                if(isset($resposta_2->respostaFormulario)){
                                    foreach($resposta_2->respostaFormulario->listaCampoResposta as $respostaForm)
                                    {
                                        if($respostaForm->campoFormulario->codigo == "GP_CROMO_QTDE")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_mo = number_format($respostaForm->valorRespostaNumerico, 0);
                                            }
                                            else
                                            {
                                                $qtde_mo = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROMO_TIPO")
                                        {
                                            if(isset($respostaForm->valorRespostaEnumeracao))
                                            {
                                                $type_mo = $respostaForm->valorRespostaEnumeracao->codigo;
                                            }
                                            else
                                            {
                                                $type_mo = null;
                                            }
                                        }

                                    }
                                    array_push($manpowers, [
                                        "type"  => $type_mo,
                                        "qtde" => $qtde_mo
                                    ]);
                                }
                            }

                            /** field form */
                            if($resposta_2->campoFormulario->codigo == "GP_FORM_INSMO"){
                                if(isset($resposta_2->respostaFormulario)){
                                    foreach($resposta_2->respostaFormulario->listaCampoResposta as $respostaForm)
                                    {
                                        if($respostaForm->campoFormulario->codigo == "GP_CROI_QTDE")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_ins = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_ins = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CROI_INSUMO")
                                        {
                                            if(isset($respostaForm->valorRespostaEnumeracao))
                                            {
                                                $insumo = $respostaForm->valorRespostaEnumeracao->codigo;
                                                $nome = $respostaForm->valorRespostaEnumeracao->nome;
                                            }
                                            else
                                            {
                                                $insumo = null;
                                                $nome = null;
                                            }
                                        }

                                    }
                                    array_push($inputs, [
                                        "insumo"  => $insumo,
                                        "nome" => $nome,
                                        "qtde" => $qtde_ins
                                    ]);
                                }
                            }

                            /** field form */
                            if($resposta_2->campoFormulario->codigo == "GP_FORM_DESCARTE"){
                                if(isset($resposta_2->respostaFormulario)){
                                    foreach($resposta_2->respostaFormulario->listaCampoResposta as $respostaForm)
                                    {
                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_EXPED")
                                        {
                                            if(isset($respostaForm->valorRespostaTexto))
                                            {
                                                $expedicao = $respostaForm->valorRespostaTexto;
                                            }
                                            else
                                            {
                                                $expedicao = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_LOTE")
                                        {
                                            if(isset($respostaForm->valorRespostaTexto))
                                            {
                                                $lote = $respostaForm->valorRespostaTexto;
                                            }
                                            else
                                            {
                                                $lote = null;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_QTDE_DESC_DOEN")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_desc_doen = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_desc_doen = 0.000;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_QTDE_DESC_VERD")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_desc_verde = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_desc_verde = 0.000;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_QTDE_DESC_QUEB")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_desc_quebra = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_desc_quebra = 0.000;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_QTDE_DESC_SUBS")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_desc_subst = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_desc_subst = 0.000;
                                            }
                                        }

                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_QTDE_PLANTADA")
                                        {
                                            if(isset($respostaForm->valorRespostaNumerico))
                                            {
                                                $qtde_plantada = number_format($respostaForm->valorRespostaNumerico, 3, '.', '');
                                            }
                                            else
                                            {
                                                $qtde_plantada = 0.000;
                                            }
                                        }


                                        if($respostaForm->campoFormulario->codigo == "GP_CRD_INSUMO")
                                        {
                                            if(isset($respostaForm->valorRespostaEnumeracao))
                                            {
                                                $insumo = $respostaForm->valorRespostaEnumeracao->codigo;
                                                $nome = $respostaForm->valorRespostaEnumeracao->nome;
                                            }
                                            else
                                            {
                                                $insumo = null;
                                                $nome = null;
                                            }
                                        }

                                    }
                                    array_push($discards, [
                                        "insumo"  => $insumo,
                                        "nome" => $nome,
                                        "lote" => $lote,
                                        "expedicao" => $expedicao,
                                        "qtde_plantada" => $qtde_plantada,
                                        "qtde_desc_sub" => $qtde_desc_subst,
                                        "qtde_desc_verde" => $qtde_desc_verde,
                                        "qtde_desc_doen" => $qtde_desc_doen,
                                        "qtde_desc_quebra" => $qtde_desc_quebra,
                                    ]);
                                }
                            }
                        }
                    }


                    echo "LOCALS: \n";
                    var_dump($locals);
                    echo "OBJECTS: \n";
                    var_dump($objects);
                    echo "MANPOWERS: \n";
                    var_dump($manpowers);
                    echo "INPUTS: \n";
                    var_dump($inputs);
                    echo "DISCARDS: \n";
                    var_dump($discards);


                    $person_related_id = ($person_related) ? ($this->consultDatabase("person_related", "oid", $person_related, "", "")) : null;
                    $operation_id = ($operation) ? ($this->consultDatabase("operations", "code", $operation, "", $person_related_id->id)) : null;
                    $result_center_id = ($result_center) ? ($this->consultDatabase("result_centers", "code", $result_center, "", "")) : null;
                    $forestry_note_status_id = $this->consultDatabase("forestry_note_statuses", "status", "EM ANÁLISE", "", "");
                    $person_employee_id = ($person_employee) ? ($this->consultDatabase("person_employees", "code", $person_employee, "", "")) : null;
                    $data_forestry_note = [
                        "dtstart" => $dtstart." ".$hrstart,
                        "dtend" => $dtend." ".$hrend,
                        "person_related_id" => ($person_related_id) ? $person_related_id->id : null,
                        "operation_id" => ($operation_id) ? $operation_id->id : null,
                        "person_employee_id" => ($person_employee_id) ? $person_employee_id->id : null,
                        "result_center_id" => ($result_center_id) ? $result_center_id->id : null,
                        "smartquestion" => ($smartquestion) ? $smartquestion : null,
                        "forestry_note_status_id" => ($forestry_note_status_id) ? $forestry_note_status_id->id : null,
                        "created_at" => date('Y-m-d H:i:s')
                    ];
                    //var_dump($data_forestry_note);
                    /* Insert Database */
                    $forestry_note = ForestryNote::where('smartquestion', '=', $smartquestion)->first();
                    if($forestry_note)
                    {
                        /*
                        $forestry_note->dtstart = $data_forestry_note['dtstart'];
                        $forestry_note->dtend = $data_forestry_note['dtend'];
                        $forestry_note->person_related_id = $data_forestry_note['person_related_id'];
                        $forestry_note->operation_id = $data_forestry_note['operation_id'];
                        $forestry_note->result_center_id = $data_forestry_note['result_center_id'];
                        $forestry_note->updated_at = date('Y-m-d H:i:s');
                        $forestry_note->save();
                        */
                        $forestry_note_id = $forestry_note->id;
                    }
                    else
                    {
                        try
                        {
                            $forestry_note_insert = ForestryNote::create($data_forestry_note);
                            $forestry_note_id = $forestry_note_insert->id;
                            if($manpowers)
                            {
                                foreach($manpowers as $item)
                                {   try{
                                        $forestry_manpower_type_id = $this->consultDatabase('forestry_manpower_types', 'id', $item['type'], '', '');
                                        $data_forestry_note_manpower = [
                                            "forestry_note_id"  => $forestry_note_id,
                                            "forestry_manpower_type_id" => ($forestry_manpower_type_id) ? $forestry_manpower_type_id->id : null,
                                            "amount" => $item['qtde'],
                                            "created_at" => date('Y-m-d H:i:s')
                                        ];
                                        echo "MANPOWER";
                                        var_dump($data_forestry_note_manpower);
                                        $forestry_note_manpower_insert = ForestryNoteManpower::create($data_forestry_note_manpower);
                                    }
                                    catch(\Exception $e)
                                    {
                                        $dataInsertInconsistency = [
                                            'user'          => 'admin',
                                            'application'   => 'forestryNote',
                                            'spreadsheet'   => 'SQ',
                                            'description'   => 'Mão-de-Obra '.$item['type'].' NÃO encontrado.',
                                            'line'          => $smartquestion,
                                            'created_at'    => date('Y-m-d H:i:s')
                                        ];
                                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                                        constinue;
                                    }
                                }
                            }

                            if($locals)
                            {
                                foreach($locals as $item)
                                {
                                    try{
                                        $int_location_id = $this->consultDatabase('int_locations', 'location', $item['talhao'], '', $item['projeto']);
                                        $int_location_id_nd = $this->consultDatabase('int_locations', 'location', 'NÃO IDENTIFICADO', '', 'NID');
                                        $forestry_cause_id = ($item['causa']) ? $this->consultDatabase('forestry_causes', 'id', $item['causa'], '', '') : null;
                                        $data_forestry_note_locals = [
                                            "forestry_note_id" => $forestry_note_id,
                                            "int_location_id" => ($int_location_id) ? $int_location_id->id : $int_location_id_nd->id,
                                            "amount" => $item['qtde'],
                                            "close" => ($item['fechado']) ? 'S' : 'N',
                                            "rework" => ($item['retrabalho']) ? 'S' : 'N',
                                            "reapplication" => ($item['reaplicacao']) ? 'S' : 'N',
                                            "forestry_cause_id" => ($forestry_cause_id) ? $forestry_cause_id->id : null,
                                            "notes" => ($int_location_id) ? $item['obs'] : 'Local NÃO encontrado. Local apontado '.$item['projeto'].'/'.$item['talhao'],
                                            "created_at" => date('Y-m-d H:i:s')
                                        ];
                                        echo "LOCALS";
                                        var_dump($data_forestry_note_locals);
                                        $forestry_note_locals_insert = ForestryNoteLocal::create($data_forestry_note_locals);

                                        /* talhao fechado */
                                        if($data_forestry_note_locals['close'] == 'S')
                                        {
                                            $closes = ForestryNoteLocal::join('forestry_notes', 'forestry_note_locals.forestry_note_id', '=', 'forestry_notes.id')
                                                                    ->where('forestry_notes.operation_id', '=', $data_forestry_note['operation_id'])
                                                                    ->where('forestry_note_locals.int_location_id', '=', $data_forestry_note_locals['int_location_id'])
                                                                    ->select(['forestry_note_locals.id as forestry_note_locals_id'])
                                                                    ->get();
                                            if($closes)
                                            {
                                                $uniqid = uniqid();
                                                foreach($closes as $close)
                                                {
                                                    var_dump($close->forestry_note_locals_id);
                                                    $update = ForestryNoteLocal::find($close->forestry_note_locals_id);
                                                    $update->close = 'S';
                                                    $update->uniqid = $uniqid;
                                                    $update->save();
                                                }
                                            }
                                        }
                                    }
                                    catch (\Exception $e)
                                    {
                                        $dataInsertInconsistency = [
                                            'user'          => 'admin',
                                            'application'   => 'forestryNote',
                                            'spreadsheet'   => 'SQ',
                                            'description'   => 'Local '.$item['projeto'].'/'.$item['talhao'].' NÃO encontrado.',
                                            'line'          => $smartquestion,
                                            'created_at'    => date('Y-m-d H:i:s')
                                        ];
                                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                                        continue;
                                    }
                                }
                            }

                            if($objects)
                            {
                                foreach($objects as $item)
                                {
                                    try{
                                        $object_id = $this->consultDatabase('objects', 'code', $item['objeto'], '', '');
                                        $data_forestry_note_objects = [
                                            "forestry_note_id" => $forestry_note_id,
                                            "object_id" => ($object_id) ? $object_id->id : null,
                                            "created_at" => date('Y-m-d H:i:s')
                                        ];
                                        echo "OBJECT";
                                        var_dump($data_forestry_note_objects);
                                        $forestry_note_objects_insert = ForestryNoteObject::create($data_forestry_note_objects);
                                    }
                                    catch(\Exception $e)
                                    {
                                        $dataInsertInconsistency = [
                                            'user'          => 'admin',
                                            'application'   => 'forestryNote',
                                            'spreadsheet'   => 'SQ',
                                            'description'   => 'Objeto '.$item['objeto'].' NÃO encontrado.',
                                            'line'          => $smartquestion,
                                            'created_at'    => date('Y-m-d H:i:s')
                                        ];
                                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                                        continue;
                                    }
                                }
                            }

                            if($inputs)
                            {
                                foreach($inputs as $item)
                                {
                                    if($item['insumo'])
                                    {
                                        try{
                                            $product_id = $this->consultDatabase('products', 'id', $item['insumo'], '', '');
                                            $data_forestry_note_inputs = [
                                                "forestry_note_id" => $forestry_note_id,
                                                "product_id" => ($product_id) ? $product_id->id : null,
                                                "amount" => $item['qtde'],
                                                "measure" => ($product_id) ? $product_id->measure->initial : null,
                                                "created_at" => date('Y-m-d H:i:s')
                                            ];
                                            echo "INPUTS";
                                            var_dump($data_forestry_note_inputs);
                                            $forestry_note_inputs_insert = ForestryNoteInput::create($data_forestry_note_inputs);
                                        }
                                        catch (\Exception $e)
                                        {
                                            $dataInsertInconsistency = [
                                                'user'          => 'admin',
                                                'application'   => 'forestryNote',
                                                'spreadsheet'   => 'SQ',
                                                'description'   => 'Produto/Insumo '.$item['nome'].' NÃO encontrado.',
                                                'line'          => $smartquestion,
                                                'created_at'    => date('Y-m-d H:i:s')
                                            ];
                                            $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                                            continue;
                                        }
                                    }
                                }
                            }

                            if($discards)
                            {
                                foreach($discards as $item)
                                {
                                    try{
                                        $product_id = $this->consultDatabase('products', 'id', $item['insumo'], '', '');
                                        $data_forestry_note_discards = [
                                            "forestry_note_id" => $forestry_note_id,
                                            "product_id" => ($product_id) ? $product_id->id : null,
                                            "measure" => ($product_id) ? $product_id->measure->initial : null,
                                            "part" => $item['lote'],
                                            "expedition" => $item['expedicao'],
                                            "amount_planted" => $item['qtde_plantada'],
                                            "amount_received" => $item['qtde_plantada'] + ($item['qtde_desc_sub'] + $item['qtde_desc_verde'] + $item['qtde_desc_doen'] + $item['qtde_desc_quebra']),
                                            "amount_desc_sub" => $item['qtde_desc_sub'],
                                            "amount_desc_broken" => $item['qtde_desc_quebra'],
                                            "amount_desc_green" => $item['qtde_desc_verde'],
                                            "amount_desc_disease" => $item['qtde_desc_doen'],
                                            "amount_desc_total" => ($item['qtde_desc_sub'] + $item['qtde_desc_verde'] + $item['qtde_desc_doen'] + $item['qtde_desc_quebra']),
                                            "perc_desc_total" => ($item['qtde_desc_sub'] + $item['qtde_desc_verde'] + $item['qtde_desc_doen'] + $item['qtde_desc_quebra'])/($item['qtde_plantada'] + ($item['qtde_desc_sub'] + $item['qtde_desc_verde'] + $item['qtde_desc_doen'] + $item['qtde_desc_quebra'])),
                                            "created_at" => date('Y-m-d H:i:s')
                                        ];
                                        echo "DISCARD";
                                        var_dump($data_forestry_note_discards);
                                        $forestry_note_discards_insert = ForestryNoteDescard::create($data_forestry_note_discards);
                                    }
                                    catch (\Exception $e)
                                    {
                                        $dataInsertInconsistency = [
                                            'user'          => 'admin',
                                            'application'   => 'forestryNote',
                                            'spreadsheet'   => 'SQ',
                                            'description'   => 'Produto/Insumo '.$item['nome'].' do plantio NÃO encontrado. Erro: '.$e,
                                            'line'          => $smartquestion,
                                            'created_at'    => date('Y-m-d H:i:s')
                                        ];
                                        $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                                        continue;
                                    }
                                }
                            }
                        }
                        catch (\Exception $e)
                        {
                            $dataInsertInconsistency = [
                                'user'          => 'admin',
                                'application'   => 'forestryNote',
                                'spreadsheet'   => 'SQ',
                                'description'   => $e->getMessage(),
                                'line'          => $smartquestion,
                                'created_at'    => date('Y-m-d H:i:s')
                            ];
                            $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
                            continue;
                        }
                    }
                    // update status atendimento in smartquestion
                    $paramStatus = array(
                        "login" => env('WS_SQUSER'),
                        "senha" => env('WS_SQPSWD'),
                        "codigoStatusAtendimento" => 'INTEGRADO',
                        "numeroAtendimento" => $smartquestion,
                    );
                    $returnStatus = $this->soapSmartQuestion('atualizarStatusAtendimento', $paramStatus);
                }
            }
        }
        catch(\Exception $e)
        {
            $dataInsertInconsistency = [
                'user'          => 'admin',
                'application'   => 'forestryNote',
                'spreadsheet'   => 'SQ',
                'description'   => $e->getMessage(),
                'line'          => 'Webservices',
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $inconsistency = ImportInconsistency::create($dataInsertInconsistency);
        }
    }
}
