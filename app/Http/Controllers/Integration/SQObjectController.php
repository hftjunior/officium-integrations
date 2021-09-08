<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VwObject;

class SQObjectController extends Controller
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

    public function pointObject (){
        $data = VwObject::orderBy('code')->get();
        $pointObject = array();
        foreach ($data as $key => $value) {
            $pointObject[] = array(
                "ativo" => ($value['status'] == "ATIVO") ? 1 : 0, 
                "cidade" => array("codigo" => "CVL", "estado" => array("sigla" => "MG")),
                "codigo" => $value['code'],
                "nome"  => $value['code'].' - '.$value['type'].' - '.$value['manufacture'].'/'.$value['model'],
                "tipoPontoAtendimento" => array("codigo" => "VEICULO"),
                "unidadeAtendimento" => array("codigo" => "MT13", "regional" => array("codigo" => "MECANIZACAO", "empresa" => array("codigo" => "GP"))),
            );
        }

        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "pontoAtendimentos" => $pointObject,
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarPontoAtendimentos', $listParams);
        print_r($listReturn);
        //print_r($listParams);
    }    
}
