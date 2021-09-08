<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ObjectNoteFuelLocal;

class SQListObjectNoteFuelLocalsController extends Controller
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

    public function listFuelLocals (){
        $data = ObjectNoteFuelLocal::orderBy('local')->where('status', '=', 'A')->get();
        $locals = array();
        foreach ($data as $key => $value) {
            $locals[] = array(
                "ativo" => 1,
                "codigo" => $value['id'],
                "nome"  => $value['local'],
                "sequencia" => $key,
            );
        }

        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_LOCAIS_ABASTECIMENTO', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $locals)            
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);        
    }
}
