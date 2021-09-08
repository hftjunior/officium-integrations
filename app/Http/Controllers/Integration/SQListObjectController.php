<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VwObject;


class SQListObjectController extends Controller
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

    public function listObject (){
        $data = VwObject::orderBy('code')->where('status', '=', 'ATIVO')->get();
        $object = array();
        foreach ($data as $key => $value) {
            $object[] = array(
                "ativo" => 1,
                "codigo" => $value['code'],
                "nome"  => $value['code'].' - '.$value['type'].' - '.$value['manufacture'].'/'.$value['model'],
                "sequencia" => $key,
            );
        }

        //var_dump($object);
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'OPE_OBJETOS',
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $object)
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);
    }
}
