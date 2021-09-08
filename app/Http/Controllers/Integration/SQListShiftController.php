<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersonEmployeeShift;

class SQListShiftController extends Controller
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

    public function listShift (){
        $data = PersonEmployeeShift::orderBy('shift')->where('status', '=', 'A')->get();
        $shift = array();
        foreach ($data as $key => $value) {
            $shift[] = array(
                "ativo" => 1,
                "codigo" => $value['id'],
                "nome"  => $value['shift'].' ('.$value['input'].' às '.$value['output'].')',
                "sequencia" => $key,
            );
        }

        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_TURNOS', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $shift)            
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);        
    }
}
