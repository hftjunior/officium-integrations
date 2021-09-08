<?php

namespace App\Http\Controllers\Integration;

use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SQListInputController extends Controller
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

    public function listInput (){
        $categories = [20,21];
        $data = Product ::orderBy('product')
                        ->where('status', '=', 'A')
                        ->where('product_category_id', '=', 20)
                        ->orWhere('product_category_id', '=', 21)->get();
        $input = array();
        foreach ($data as $key => $value) {
            $input[] = array(
                "ativo" => 1,
                "codigo" => $value['id'],
                "nome"  => $value['product'],
                "sequencia" => $key,
            );
        }
        //var_dump($input);
        $listParams = array(
            "login" => env('WS_SQUSER'),
            "senha" => env('WS_SQPSWD'),
            "tiposCampoEnumeracao" => array('codigo' => 'OPE_INSUMOS',
                                            'empresa' => array('codigo' => 'GP'),
                                            'listaOpcaoCampoEnumeracao' => $input)
        );
        $listReturn = $this->soapSmartQuestion('criarOuAtualizarTipoCampoLista', $listParams);
        print_r($listReturn);
    }
}
