<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ForestryManpowerType;

class SQListForestryManpowerTypeController extends Controller
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

    public function listForestryManpowerType (){
        $data = ForestryManpowerType::orderBy('id')->where('active', '=', 'A')->get();
        $type = array();
        foreach ($data as $key => $value) {
            $type[] = array(
                "ativo" => 1,
                "codigo" => $value['id'],
                "nome"  => $value['type'],
                "sequencia" => $key,
            );
        }
        //var_dump($type);
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'OPE_TIPO_MAO_OBRA',
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $type)
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);
    }
}
