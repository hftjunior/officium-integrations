<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Objects;
use App\Models\PersonEmployee;
use App\Models\PersonProvider;
use App\Models\ResultCenter;
use App\Models\Operation;
use App\Models\Product;
use App\Models\Person;
use App\Models\LogIntegration;
use App\Models\Notification;
use App\Models\ObjectNoteFuelSupply;

class SQObjectFuelSupplyController extends Controller
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

    public function consultDatabase($table, $column, $value){
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
		if($table == "products"){
            $consult = Product::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Product::where($column, "=", $value)->first());
		}
		if($table == "people"){
            $consult = Person::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (Person::where($column, "=", $value)->first());
        }
    }

    public function objectFuelSupplies(){
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
        $supply = array();
        for($i=0; $i<count($data); $i++){
	        $form = $data[$i]->tipoVisita->codigo;
	        if($form == "GP_ABASTECIMENTO"){
				$contForm ++;
				$dt = '';
				$objectCode = $data[$i]->pontoAtendimento->codigo;
				$related = "";
				$resultCenter = '';
				$local = '';
				$operation = '';
				$operator = '';
				$pedometer = 0;
				$provider = '';
				$product = '';
				$amount = 0.0;
				$vlrunit = 0.0;
				$responsible = '';
				$code = $data[$i]->numeroAtendimento;
				$source = '';
				$notes = '';

        		foreach($data[$i]->listaResposta->listaCampoResposta as $resposta){
					/** field list */
					if($resposta->campoFormulario->codigo == "MEC_PRODUTO"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $product = $resposta->valorRespostaEnumeracao->codigo;
						}
			        }
			        if($resposta->campoFormulario->codigo == "MEC_FORNECEDOR"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $provider = $resposta->valorRespostaEnumeracao->codigo;
						}
			        }
			        if($resposta->campoFormulario->codigo == "MEC_OPERADOR"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $operator = $resposta->valorRespostaEnumeracao->codigo;
						}
			        }
			        if($resposta->campoFormulario->codigo == "MEC_OPERACAO"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $operation = $resposta->valorRespostaEnumeracao->codigo;
					    }
					}
					if($resposta->campoFormulario->codigo == "MEC_CR"){
						if(isset($resposta->valorRespostaEnumeracao)){
							$resultCenter = $resposta->valorRespostaEnumeracao->codigo;
						}
					 }
					if($resposta->campoFormulario->codigo == "MEC_LOCAL"){
						if(isset($resposta->valorRespostaEnumeracao)){
							$local = $resposta->valorRespostaEnumeracao->codigo;
						}
					 }
					 if($resposta->campoFormulario->codigo == "MEC_ENCARREGADO"){
						if(isset($resposta->valorRespostaEnumeracao)){
							$responsible = $resposta->valorRespostaEnumeracao->codigo;
						}
				 	}

					/** field number */
			        if($resposta->campoFormulario->codigo == "MEC_VLRUNIT"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $vlrunit = $resposta->valorRespostaNumerico;
						}
			        }
			        if($resposta->campoFormulario->codigo == "MEC_QTDE"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $amount = $resposta->valorRespostaNumerico;
						}
			        }
			        if($resposta->campoFormulario->codigo == "MEC_HODHOR"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $pedometer = $resposta->valorRespostaNumerico;
						}
					}

					/** field date */
			        if($resposta->campoFormulario->codigo == "MEC_DATA"){
               	        if(isset($resposta->valorRespostaData)){
					        $dt = $this->convertDate($resposta->valorRespostaData);
						}
					}
					if($resposta->campoFormulario->codigo == "MEC_HRABASTECIMENTO"){
							if(isset($resposta->valorRespostaHora)){
							$time = $this->convertHours($resposta->valorRespostaHora);
						}
					}


					/** field text */

					if($resposta->campoFormulario->codigo == "MEC_OBSERVACAO"){
               	        if(isset($resposta->valorRespostaTexto)){
					        $notes = $resposta->valorRespostaTexto;
						}
					}
                }
                $object_id = (empty($objectCode)) ? Null : ($this->consultDatabase("objects", "code", $objectCode));
                $related_id = (empty($resultCenter)) ? Null : ($this->consultDatabase("result_centers", "code", $resultCenter));
				$result_center_id = (empty($resultCenter)) ? Null : ($this->consultDatabase("result_centers", "code", $resultCenter));
				$operation_id = (empty($operation)) ? Null : ($this->consultDatabase("operations", "code", $operation));
				$operator_id = (empty($operator)) ? Null : ($this->consultDatabase("person_employees", "code", $operator));
				$provider_id = (empty($provider)) ? Null : ($this->consultDatabase("people", "cpfcnpj", $provider));
				$product_id = (empty($product)) ? Null : ($this->consultDatabase("products", "code", $product));
				$responsible_id = (empty($responsible)) ? Null : ($this->consultDatabase("person_employees", "code", $responsible));

                $supply[] = [ "date" => $dt.' '.$time,
							  "object_id" => (empty($object_id)) ? Null : $object_id->id,
				        	  "related_id" => (empty($related_id)) ? Null : $related_id->related->id,
							  "result_center_id" => (empty($result_center_id)) ? Null : $result_center_id->id,
							  "local_id" => $local,
							  "operation_id" => (empty($operation_id)) ? Null : $operation_id->id,
							  "operator_id" => (empty($operator_id)) ? Null : $operator_id->id,
						      "pedometer" => $pedometer,
							  "provider_id" => (empty($provider_id)) ? Null : $provider_id->provider->id,
							  "product_id" => (empty($product_id)) ? Null : $product_id->id,
							  "amount" => $amount,
							  "val_unit" => $vlrunit,
							  "responsible_id" => (empty($responsible_id)) ? Null : $responsible_id->id,
							  "code" => $code,
							  "source" => 'SQ',
						      "notes" => $notes
                            ];
	        }
		}
        /** Insert Database */
        $total = count($supply);
        $import = 0;
		foreach ($supply as $key => $value) {
            if(empty($value['object_id'])){
                continue;
            }else{
                $check = ObjectNoteFuelSupply::where("code", "=", $value['code'])->doesntExist();
                if($check){
                    try{
                        $stm_supply = ObjectNoteFuelSupply::create($value);
                        LogIntegration::create([
                            'user' => 'system',
                            'form' => 'GP_ABASTECIMENTO',
                            'code' => $value['code'],
                            'status' => 'S',
                            'message' => 'importação efetuada com sucesso',
                        ]);
                        $import ++;
                    }catch(\Illuminate\Database\QueryException $ex){
                        LogIntegration::create([
                            'user' => 'system',
                            'form' => 'GP_ABASTECIMENTO',
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
        Notification::create([
            'type' => 'abastecimento',
            'notifiable_type' => 'info',
            'notifiable_id' => '3',
            'data' => '[ABAST] Foram importados '.$import.' registros',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
