<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Objects;
use App\Models\ObjectCodeAgency;
use App\Models\ObjectAgency;
use App\Models\PersonEmployee;
use App\Models\PersonProvider;
use App\Models\PersonDocument;
use App\Models\PersonDocumentType;
use App\Models\ResultCenter;
use App\Models\Operation;
use App\Models\CoalUnit;
use App\Models\CoalStock;
use App\Models\Person;
use App\Models\LogIntegration;
use App\Models\Notification;
use App\Models\CoalExpedition;
use App\Models\CoalOrder;
use App\Models\CoalMeasure;

class SQCoalExpeditionController extends Controller
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
        if($table == "objects"){
            $consult = Objects::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Objects::where($column, "=", $value)->first());
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
            return ($consult) ? null : (Operation::where($column, "=", $value)->first());
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

    public function coalExpeditions(){
		$date = new \DateTime();
		$dtinitial = $date;
        $dtinitial = strtoupper($dtinitial->format('Y-m-d'));
		$dtend = $date->add(new \DateInterval('P1D'));
		$dtend = strtoupper($dtend->format('Y-m-d'));

        $arrayParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "dataInicial" => $dtinitial,
            "dataFinal" => $dtend
        );
        $data = $this->soapSmartQuestion('getAtendimentosPeriodo', $arrayParams);

        $contForm = 0;
        $contInsert = 0;
        $expedition = array();
        for($i=0; $i<count($data); $i++){
            $form = $data[$i]->tipoVisita->codigo;
            if($form == "GP_ORDEMCARREGAMENTO"){
                //print_r($data[$i]);
                $contForm ++;
				$coal_unit = $data[$i]->pontoAtendimento->unidadeAtendimento->oid;
				$coal_stock_id = "";
                $dtexpedition = "";
                $hrexpedition = "";
				$client = '';
				$provider = '';
				$measure = '';
                $platetruck = '';
                $platetrailer = '';
				$net_weight = '';
				$gross_weight = '';
                $amount = 0.0;
                $volume = 0.0;
				$vlrunit = 0.0;
                $project_code = '';
                $order = '';
                $provider_code = '';
                $conductor = '';
                $notes = '';
                $code = $data[$i]->numeroAtendimento;
                $seal = '';
                $antt = '';

        		foreach($data[$i]->listaResposta->listaCampoResposta as $resposta){
					/** field list */
					if($resposta->campoFormulario->codigo == "CAR_TRANSPORTADORA"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $provider = $resposta->valorRespostaEnumeracao->codigo;
						}
			        }
			        if($resposta->campoFormulario->codigo == "CAR_UNDMEDIDA"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $measure = $resposta->valorRespostaEnumeracao->codigo;
						}
			        }
			        if($resposta->campoFormulario->codigo == "CAR_CLIENTE"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $client = $resposta->valorRespostaEnumeracao->codigo;
						}
                    }

                    if($resposta->campoFormulario->codigo == "CAR_CONDUTOR"){
                        if(isset($resposta->valorRespostaEnumeracao)){
                         $conductor = $resposta->valorRespostaEnumeracao->codigo;
                        }
                    }

                    /** field number */
			        if($resposta->campoFormulario->codigo == "CAR_VOLUME"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $volume = $resposta->valorRespostaNumerico;
						}
			        }
			        if($resposta->campoFormulario->codigo == "CAR_VALORUNIT"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $vlrunit = $resposta->valorRespostaNumerico;
						}
			        }
			        if($resposta->campoFormulario->codigo == "CAR_QTDITEM"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $amount = $resposta->valorRespostaNumerico;
						}
                    }
                    if($resposta->campoFormulario->codigo == "CAR_PESOLIQ"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $net_weight = $resposta->valorRespostaNumerico;
						}
                    }
                    if($resposta->campoFormulario->codigo == "CAR_PESOBRUTO"){
                        if(isset($resposta->valorRespostaNumerico)){
                            $gross_weight = $resposta->valorRespostaNumerico;
                        }
                    }

                    /** field date */
			        if($resposta->campoFormulario->codigo == "CAR_DATA"){
               	        if(isset($resposta->valorRespostaData)){
					        $dtexpedition = $this->convertDate($resposta->valorRespostaData);
						}
					}
					if($resposta->campoFormulario->codigo == "CAR_HORA"){
							if(isset($resposta->valorRespostaHora)){
							$hrexpedition = $this->convertHours($resposta->valorRespostaHora);
						}
					}

					/** field text */
					if($resposta->campoFormulario->codigo == "CAR_PLACACAR"){
               	        if(isset($resposta->valorRespostaTexto)){
					        $platetrailer = $resposta->valorRespostaTexto;
						}
                    }
                    if($resposta->campoFormulario->codigo == "CAR_PLACACAV"){
                        if(isset($resposta->valorRespostaTexto)){
                            $platetruck = $resposta->valorRespostaTexto;
                        }
                    }
                    if($resposta->campoFormulario->codigo == "CAR_OBSERVACOES"){
                        if(isset($resposta->valorRespostaTexto)){
                            $notes = $resposta->valorRespostaTexto;
                        }
                    }
                    if($resposta->campoFormulario->codigo == "CAR_LACRE"){
                        if(isset($resposta->valorRespostaTexto)){
                            $seal = $resposta->valorRespostaTexto;
                        }
                    }
                }
                $coal_unit_id = (empty($coal_unit)) ? Null : ($this->consultDatabase("coal_units", "oid", $coal_unit, "", ""));
                $coal_stock_id = (empty($coal_unit)) ? Null : ($this->consultDatabase("coal_stocks", "coal_unit_id", $coal_unit_id->id, "", ""));
                $person_provider_id = (empty($provider)) ? Null : ($this->consultDatabase("people", "cpfcnpj", $provider, "", ""));
                $antt = (empty($person_provider_id)) ? Null : ($this->consultDatabase("antt", "people_id", $person_provider_id->id, "", ""));
                $person_client_id = (empty($client)) ? Null : ($this->consultDatabase("people", "cpfcnpj", $client, "", ""));
                $coal_order_id = (empty($person_client_id)) ? Null : ($this->consultDatabase("coal_order", "person_client_id", $person_client_id->client->id, "coal_unit_id", $coal_unit_id->id));
                $coal_measure_id = (empty($measure)) ? Null : ($this->consultDatabase("coal_measures", "initial", $measure, "", ""));
                $person_employeers_id = (empty($conductor)) ? Null : ($this->consultDatabase("person_employees", "code", $conductor, "", ""));
                $cnh = (empty($person_employeers_id)) ? Null : ($this->consultDatabase("documents", "people_id", $person_employeers_id->employee->id, "", ""));
                $object_truck = (empty($platetruck)) ? Null : ($this->consultDatabase("objects", "code", $platetruck, "", ""));
                $antt_truck = (empty($object_truck)) ? Null : ($this->consultDatabase("object_code_agency", "object_id", $object_truck->id, "", ""));
                $object_trailer = (empty($platetrailer)) ? Null : ($this->consultDatabase("objects", "code", $platetrailer, "", ""));
                $antt_trailer = (empty($object_trailer)) ? Null : ($this->consultDatabase("object_code_agency", "object_id", $object_trailer->id, "", ""));
                /*
                $product_id = (empty($product)) ? Null : ($this->consultDatabase("products", "code", $product));
				$responsible_id = (empty($responsible)) ? Null : ($this->consultDatabase("person_employees", "code", $responsible));
                */
                $expedition[] = [
                            "coal_order_id" => (empty($coal_order_id)) ? Null : $coal_order_id->id ,
                            "coal_unit_id" => (empty($coal_unit_id)) ? Null : $coal_unit_id->id ,
                            "coal_stock_id" => (empty($coal_stock_id)) ? Null : $coal_stock_id->id ,
                            "result_center_id" => (empty($coal_unit_id)) ? Null : $coal_unit_id->result_center_id ,
                            "dtexpedition" => $dtexpedition.' '.$hrexpedition,
                            "person_client_id" => (empty($person_client_id)) ? Null : $person_client_id->client->id ,
                            "person_provider_id" => (empty($person_provider_id)) ? Null : $person_provider_id->provider->id ,
                            "antt" => (empty($antt)) ? Null : $antt->code ,
                            "charter" => (empty($coal_order_id)) ? Null : $coal_order_id->charter ,
                            "person_employees_id" => (empty($person_employeers_id)) ? Null : $person_employeers_id->id,
                            "cpf" => (empty($person_employeers_id)) ? Null : $person_employeers_id->employee->cpfcnpj,
                            "cnh" => (empty($cnh)) ? Null : $cnh->code,
                            "truck_plate" => $platetruck ,
                            "truck_antt" => (empty($antt_truck)) ? Null : $antt_truck->code,
                            "trailer_plate" => $platetrailer,
                            "trailer_antt" => (empty($antt_trailer)) ? Null : $antt_trailer->code,
                            "net_weight" => (empty($object_trailer)) ? 0.000 : $object_trailer->net_weight,
                            "gross_weight" => (empty($object_trailer)) ? 0.000 : $object_trailer->gross_weight,
                            "amount" => $amount ,
                            "coal_measure_id" => (empty($coal_measure_id)) ? Null : $coal_measure_id->id ,
                            "volume" => (empty($object_trailer)) ? 0.000 : $object_trailer->volume,
                            "vlrunit" => (empty($coal_order_id)) ? Null : $coal_order_id->vlrunit ,
                            "notes" => $notes ,
                            "code" => $code ,
                            "seal" => $seal,
                        ];
            }
        }
        //print_r($expedition);
        /** Insert Database */
        $total = count($expedition);
        $import = 0;
        foreach ($expedition as $key => $value) {
            if(empty($value['person_client_id'])){
                continue;
            }else {
                $check = CoalExpedition::where("code", "=", $value['code'])->doesntExist();
                if($check){
                    try{
                        $stm_expedition = CoalExpedition::create($value);
                        LogIntegration::create([
                            'user' => 'system',
                            'form' => 'GP_ORDEMCARREGAMENTO',
                            'code' => $value['code'],
                            'status' => 'S',
                            'message' => 'importação efetuada com sucesso',
                        ]);
                        Notification::create([
                            'type' => 'carregamento',
                            'notifiable_type' => 'info',
                            'notifiable_id' => '4',
                            'data' => '[CARREG] Uma nova ordem de carregamento foi incluída.',
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        $import ++;
                    }catch(\Illuminate\Database\QueryException $ex){
                        LogIntegration::create([
                            'user' => 'system',
                            'form' => 'GP_ORDEMCARREGAMENTO',
                            'code' => $value['code'],
                            'status' => 'F',
                            'message' => $ex->getMessage(),
                        ]);
                    }
                    // update status atendimento in smartquestion
                    $paramStatus = array(
                        "login" => env('WS_SQUSER'),
                        "senha" => env('WS_SQPSWD'),
                        "codigoStatusAtendimento" => 'INTEGRADO',
                        "numeroAtendimento" => $value['code'],
                    );
                    $returnStatus = $this->soapSmartQuestion('atualizarStatusAtendimento', $paramStatus);
                }
            }
        }
    }
}
