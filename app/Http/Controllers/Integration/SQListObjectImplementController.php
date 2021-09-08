<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ObjectImplement;


class SQListObjectImplementController extends Controller
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

    public function listObjectImplement (){
        $data = ObjectImplement::orderBy('code')->where('status', '=', 'Ativo')->get();
        $implement = array();
        foreach ($data as $key => $value) {
            $implement[] = array(
                "ativo" => 1,
                "codigo" => $value['code'],
                "nome"  => $value['code'].' - '.$value['type'].' - '.$value['manufacture'].'/'.$value['model'],
                "sequencia" => $key,
            );
        }

        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_IMPLEMENTOS', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $implement)            
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);                
    }
}
