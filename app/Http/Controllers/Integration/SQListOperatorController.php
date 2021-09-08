<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersonEmployee;

class SQListOperatorController extends Controller
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

    public function listOperator (){
        $data = PersonEmployee::orderBy('code')->where('status', '=', 'A')
                                               ->whereIn('role_id', [1031,2237,2238,2239,2241,2242,2243,2245,2246,
                                               2270,1031,1032,1034,1035,1339,1340,2221,2222,2240,2260,2263,1037,1048,
                                               1638,1669,1670,1672,1673,1674,1696,1697,1698,1699,1700,1701,1702,1703,
                                               1704,1705,1728,1732,1734,1744,2195])
                                               ->get();
        $operator = array();        
        foreach ($data as $key => $value) {
            $operator[] = array(
                "ativo" => 1,
                "codigo" => $value->code,
                "nome" => $value->employee->name,
                "sequencia" => $key
            );
        }
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'MEC_OPEVEIC', 
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $operator)            
        );        
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);        
    }
}
