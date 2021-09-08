<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Objects;
use App\Models\PersonEmployee;
use App\Models\ObjectNoteMeasure;
use App\Models\ResultCenter;
use App\Models\ObjectStopFactor;
use App\Models\ObjectNoteOperation;
use App\Models\LogIntegration;

class SQObjectNoteOperationController extends Controller
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
        if($table == "object_note_measures"){
            $consult = ObjectNoteMeasure::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (ObjectNoteMeasure::where($column, "=", $value)->first());            
        }
        if($table == "result_centers"){
            $consult = ResultCenter::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (ResultCenter::where($column, "=", $value)->first());            
		}
		if($table == "object_stop_factors"){
            $consult = ObjectStopFactor::where($column, "=", $value)->doesntExist();
            return ($consult) ? null : (ObjectStopFactor::where($column, "=", $value)->first());            
        }
    }

    public function objectNoteOperations(){
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
        $bdmo = array();
        for($i=0; $i<count($data); $i++){
	        $form = $data[$i]->tipoVisita->codigo;
	        if($form == "GP_BDMO"){
		        $contForm ++;
		        $codeSmart = "";
		        $objectCode = "";
		        $implement = "";
		        $objectCode = '';
                $operator = '';
                $shift = 0;
                $dt = '';
                $pedInitial = 0;
                $pedEnd = 0;
                $amount = 0.0;
                $time = '';
                $unit = '';
                $resultCenter = '';
                $responsible = '';
                $notes = '';		
		        $factores = array();
		        $codSmart = $data[$i]->numeroAtendimento;
		        
		        $objectCode = $data[$i]->pontoAtendimento->codigo;
		        $responsible = str_replace("-", "", $data[$i]->usuario->codigo);
        		foreach($data[$i]->listaResposta->listaCampoResposta as $resposta){
		        	if($resposta->campoFormulario->codigo == "MEC_UND"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $unit = $resposta->valorRespostaEnumeracao->codigo;
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_TURNO"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $shift = $resposta->valorRespostaEnumeracao->codigo;
						}				
			        }       
			        if($resposta->campoFormulario->codigo == "MEC_CR"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $resultCenter = $resposta->valorRespostaEnumeracao->codigo;
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_OPERADOR"){
               	        if(isset($resposta->valorRespostaEnumeracao)){
					        $operator = $resposta->valorRespostaEnumeracao->codigo;
					    }				
					}
					if($resposta->campoFormulario->codigo == "MEC_IMPLEMENTO"){
						if(isset($resposta->valorRespostaEnumeracao)){
							$implement = $resposta->valorRespostaEnumeracao->codigo;
					 	}				
				 	}
			        if($resposta->campoFormulario->codigo == "MEC_HORINICIO"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $pedInitial = $resposta->valorRespostaNumerico;
						}				
			        }   
			        if($resposta->campoFormulario->codigo == "MEC_HORFIM"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $pedEnd = $resposta->valorRespostaNumerico;
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_QTDE"){
               	        if(isset($resposta->valorRespostaNumerico)){
					        $amount = $resposta->valorRespostaNumerico;
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_DATA"){
               	        if(isset($resposta->valorRespostaData)){
					        $dt = $this->convertDate($resposta->valorRespostaData);
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_HORAINI"){
               	        if(isset($resposta->valorRespostaHora)){
					        $time = $this->convertHours($resposta->valorRespostaHora);
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_OBS"){
               	        if(isset($resposta->valorRespostaTexto)){
					        $notes = $resposta->valorRespostaTexto;
						}				
			        }
			        if($resposta->campoFormulario->codigo == "MEC_FATORES"){
               	        $factor = $resposta->respostaFormulario->listaCampoResposta;
				        $parada = '';
				        $factorTime = '';
				        $justificativa = '';				
				        foreach($factor as $item){
					        if($item->campoFormulario->codigo == "MEC_FATOR"){
						        if(isset($item->valorRespostaEnumeracao)){
									$parada = $item->valorRespostaEnumeracao->codigo;
									$factor_id = (empty($parada)) ? "" : ($this->consultDatabase("object_stop_factors", "code", $parada));
								}
					        }
					        if($item->campoFormulario->codigo == "MEC_TOTALHORAS"){
						        if(isset($item->valorRespostaHora)){
							        $factorTime = $this->convertHours($item->valorRespostaHora);
								}
					        }
					        if($item->campoFormulario->codigo == "MEC_JUSTIFICATIVA"){
						        if(isset($item->valorRespostaTexto)){
							        $justificativa = $item->valorRespostaTexto;
								}
					        }					
				        }				
						$factores[] = ["factor_id" => (empty($factor_id)) ? Null : $factor_id->id,
									   "end" => $factorTime, 
									   "notes" => $justificativa
									];
			        }			
                }
                $object_id = (empty($objectCode)) ? Null : ($this->consultDatabase("objects", "code", $objectCode));
                $implement_id = (empty($implement)) ? Null : ($this->consultDatabase("objects", "code", $implement));
                $operator_id = (empty($operator)) ? Null : ($this->consultDatabase("person_employees", "code", $operator));
                $measure_id = (empty($unit)) ? Null : ($this->consultDatabase("object_note_measures", "initial", $unit));
                $result_center_id = (empty($resultCenter)) ? Null : ($this->consultDatabase("result_centers", "code", $resultCenter));
                $responsible_id = (empty($responsible)) ? Null : ($this->consultDatabase("person_employees", "code", $responsible));
                
                $bdmo[] = [ "object_id" => (empty($object_id)) ? Null : $object_id->id,
				        	"implement_id" => (empty($implement_id)) ? Null : $implement_id->id,
					    	"operator_id" => (empty($operator_id)) ? Null : $operator_id->id,
						    "shift_id" => $shift,
						    "dtnote" => $dt." ".$time,
						    "ped_initial" => $pedInitial,
						    "ped_final" => $pedEnd,
						    "amount" => $amount,
						    "measure_id" => (empty($measure_id)) ? Null : $measure_id->id,
						    "result_center_id" => (empty($result_center_id)) ? Null : $result_center_id->id,
						    "responsible_id" => (empty($responsible_id)) ? Null : $responsible_id->id,
						    "code_smart" => $codSmart,					   
						    "notes" => $notes,
						    "factores" => array_reverse($factores)
					    ];
	        }
		}
		/*
		print_r($bdmo);
		foreach ($bdmo as $key => $value) {
			$initialDate = $value['dtnote'];
			$initial = new DateTime($value['dtnote']);
			foreach ($value['factores'] as $key => $item) {
				$endDate = new DateTime($item['end']);
				$totalMin = $initial->diff($endDate);
				$totalTime = $totalMin->format('%H:%I:%S');
				list ($hour, $min, $sec) = explode(":", $totalTime);
				$totalMin = (intval($hour)*60) + (intval($min));
				echo "total_time: ".$totalTime." totalMin: ".$totalMin."\n";
				$end = date('Y-m-d H:i:s', strtotime($initialDate.' + '.$totalMin.' minutes'));
				$totalDecimal = (intval($hour)) + (intval($min)/60);
				echo "-------------------------------------\n";
				echo "factor_id: ".$item['factor_id']."\n";
				echo "initial: ".$initialDate."\n";
				echo "end: ".$end."\n";
				echo "total_time: ".$totalTime."\n";
				echo "total_decimal: ".$totalDecimal."\n";
				
				$initialDate = $end;
				$initial = new DateTime($end);
			}
		}
		*/
		/** Insert Database */
		foreach ($bdmo as $key => $value) {
			$check = ObjectNoteOperation::where("code_smart", "=", $value['code_smart'])->doesntExist();
			if($check){
				try{
					$stm_bdmo = ObjectNoteOperation::create([
						'object_id' 		=> $value['object_id'], 
						'implement_id' 		=> $value['implement_id'], 
						'operator_id' 		=> $value['operator_id'], 
						'shift_id' 			=> $value['shift_id'], 
						'dtnote' 			=> $value['dtnote'], 
						'ped_initial' 		=> $value['ped_initial'], 
						'ped_final' 		=> $value['ped_final'], 
						'amount' 			=> $value['amount'], 
						'measure_id' 		=> $value['measure_id'], 
						'result_center_id' 	=> $value['result_center_id'], 
						'responsible_id' 	=> $value['responsible_id'], 
						'code_smart' 		=> $value['code_smart'], 
						'notes' 			=> $value['notes'],
					]);
				
					$initialDate = $value['dtnote'];
					$initial = new DateTime($value['dtnote']);
					foreach ($value['factores'] as $key => $item) {
						$endDate = new DateTime($item['end']);
						$totalMin = $initial->diff($endDate);
						$totalTime = $totalMin->format('%H:%I:%S');
						list ($hour, $min, $sec) = explode(":", $totalTime);
						$totalMin = (intval($hour)*60) + (intval($min));						
						$end = date('Y-m-d H:i:s', strtotime($initialDate.' + '.$totalMin.' minutes'));
						$totalDecimal = (intval($hour)) + (intval($min)/60);					
						
						try{
							$smt_factors = $stm_bdmo->factors()->create([
								'factor_id'		=> $item['factor_id'],
								'total_time'	=> $totalTime,
								'notes'			=> $item['notes'],
								'initial'		=> $initialDate,
								'end'			=> $end,
								'total_decimal'	=> $totalDecimal
							]);
							$initialDate = $end;
							$initial = new DateTime($end);
						}catch(Exception $e){
							LogIntegration::create([
								'user' => 'system',
								'form' => 'GP_BDMO_FATORES',
								'code' => $value['code_smart'],
								'status' => 'F',
								'message' => $e
							]);
							continue;
						}
					}
				}catch(Exception $e){
					LogIntegration::create([
						'user' => 'system',
						'form' => 'GP_BDMO',
						'code' => $value['code_smart'],
						'status' => 'F',
						'message' => $e
					]);
					continue;
				}
				LogIntegration::create([
					'user' => 'system',
					'form' => 'GP_BDMO',
					'code' => $value['code_smart'],
					'status' => 'S',
					'message' => 'importação efetuada com sucesso',
				]);
				// update status atendimento in smartquestion
				$paramStatus = array(
					"login" => env('WS_SQUSER'),
					"senha" => env('WS_SQPSWD'),
					"codigoStatusAtendimento" => 'INTEGRADO',
					"numeroAtendimento" => $value['code_smart'],					
				);
				$returnStatus = $this->soapSmartQuestion('atualizarStatusAtendimento', $paramStatus);
			}
			
		}		
    }
}
