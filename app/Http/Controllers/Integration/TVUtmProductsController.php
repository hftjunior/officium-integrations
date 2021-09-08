<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMeasure;

class TVUtmProductsController extends Controller
{
    public function soapTotvs($method, $params)
    {
        $link = env('WS_TV_QUERY_LINK');
        $options = array(
            'soap_version'  =>SOAP_1_1,
            'exceptions'    =>true,
            'trace'         =>1,
            'cache_wsdl'    =>WSDL_CACHE_DISK,
            'login'         => env('WS_TV_USER'),
            'password'      => env('WS_TV_PSWD')
        );

        $objSoaClient = new SoapClient($link, $options);
        $objResponse = $objSoaClient->__soapCall($method, array('parameters' => $params));
        return simplexml_load_string($objResponse->RealizarConsultaSQLResult);
    }

    public function getProducts()
    {
        $arrayParams = array(
            'codSentenca'   => 'wsProdutosUTM',
            'codColigada'   => '0',
            'codSistema'    => 'W',
            'parameters'    => ''
        );

        $datas = $this->soapTotvs('RealizarConsultaSQL', $arrayParams);

        foreach($datas as $key => $data)
        {
            $erp_code = $data->CODIGO;
            echo "CODIGO: ".$erp_code." | ";

            $product = $data->NOME_FANTASIA;
            echo "PRODUTO: ".$product." | ";

            $und = $data->UND;
            echo "UND: ".$und." | ";

            $conversion = number_format((float) $data->FATOR_M3, 4, '.', '');
            echo "CONVERSÃO: ".$conversion." | ";

            $semi_finished = $data->SEMI_ACABADO;
            echo "SEMI ACABADO: ".$semi_finished." | ";

            $category = ProductCategory::where('category', '=', 'MADEIRA TRATADA')->first();
            if($category)
            {
                $measure = ProductMeasure::where('initial', '=', $und)->first();
                $measure_conv = ProductMeasure::where('initial', '=', 'M3')->first();
                $fndProduct = Product::where('erp_code', '=', $erp_code)->where('product_category_id', '=', $category->id)->first();
                if($fndProduct)
                {
                    try
                    {
                        $fndProduct->product = $product;
                        $fndProduct->type = 'P';
                        $fndProduct->product_category_id = $category->id;
                        $fndProduct->product_measure_id = $measure->id;
                        $fndProduct->status = 'A';
                        $fndProduct->conversion = $conversion;
                        $fndProduct->product_measure_id_conv = $measure_conv->id;
                        $fndProduct->semi_finished = $semi_finished;
                        $fndProduct->updated_at = date('Y-m-d H:i:s');
                        $fndProduct->save();
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }
                }
                else
                {
                    try
                    {
                        $dataProduct = [
                            "product" => $product,
                            "type" => 'P',
                            "product_category_id" => $category->id,
                            "product_measure_id" => $measure->id,
                            "erp_code" => $erp_code,
                            "status" => 'A',
                            "conversion" => $conversion,
                            "product_measure_id_conv" => $measure_conv->id,
                            "semi_finished" => $semi_finished,
                            "created_at" => date('Y-d-m H:i:s')
                        ];

                        $insert_product = Product::create($dataProduct);
                    }
                    catch (\Exception $e)
                    {
                        echo "\n";
                        echo "| ERROR | ".$e->getMessage();
                        echo "\n";
                        continue;
                    }
                }
            }
            echo "\n";
        }
    }
}
