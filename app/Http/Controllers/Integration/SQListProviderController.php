<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersonProvider;

class SQListProviderController extends Controller
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

    public function listProvider (){
        $data = PersonProvider::where('status', '=', 'A')->get();
        $provider = array();
        foreach ($data as $key => $value) {
            $provider[] = array(
                "ativo" => 1,
                "codigo" => $value->person->cpfcnpj,
                "nome"  => $value->person->name,
                "sequencia" => $key,
            );
        }

        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_FORNECEDORES', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $provider)            
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);        
    }
}
