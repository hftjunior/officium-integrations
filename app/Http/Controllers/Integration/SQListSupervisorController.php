<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersonEmployee;

class SQListSupervisorController extends Controller
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

    public function listSupervisor (){
        $data = PersonEmployee::orderBy('code')->where([['role_id', '=', 1613],
                                                       ['status', '=', 'A']])
                                               ->get();
        $supervisor = array();        
        foreach ($data as $key => $value) {
            $supervisor[] = array(
                "ativo" => 1,
                "codigo" => $value->code,
                "nome" => $value->employee->name,
                "sequencia" => $key
            );
        }
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_ENCARREGADOS', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $supervisor)            
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);
        print_r($key);
    }
}
