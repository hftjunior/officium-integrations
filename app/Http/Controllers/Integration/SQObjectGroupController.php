<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VwObject;

class SQObjectGroupController extends Controller
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

    public function objectGroup (){
        $data = VwObject::orderBy('code')->get();
        /** grupo ponto de atendimento */
        //$groupPoint[] = ["codigo" => "TESTE"];
        //$assPontAtend = array();
        $count = 0;
        foreach ($data as $key => $value) {
            //echo "value: ".$value."<br/>";
            if($value->status == 'ATIVO'){
                $assPontAtend[] = [
                    "codigoPontoAtendimento" => $value->code,
                    "dataAssociacao" => date('Y-m-d')];
                $count ++;
            }
        }
        $groupPoint = ["codigo" => "TESTE",
                        "listaAssociacaoPontoAtendimento" => $assPontAtend];
        //var_dump($groupPoint);
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "grupoPontoAtendimentos" => $groupPoint,
            "apagarGruposNaoListados" => "false",
            "manterUsuarios" => "true"
        );

        $listReturn = $this->soapSmartQuestion('criarOuAtualizarGrupoPontoAtendimentos', $listParams);
        print_r($listReturn);
        var_dump($listParams);
    }
}
