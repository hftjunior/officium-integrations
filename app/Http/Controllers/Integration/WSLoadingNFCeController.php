<?php

namespace App\Http\Controllers\Integration;

use DateTime;
use DomDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class WSLoadingNFCeController extends Controller
{
    public function getData()
    {
        $url = "https://nfce.fazenda.mg.gov.br/portalnfce/sistema/qrcode.xhtml?p=31210504641376015320650650000546731472314844%7C2%7C1%7C1%7CB4C4127A93B3EB8BECC043CD2F43841D364DAA41";
        if($url)
        {
            $arrContextOptions=array(
                "ssl"=>array(
                     "verify_peer"=>false,
                     "verify_peer_name"=>false,
                ),
            );

            $html = file_get_contents($url, false, stream_context_create($arrContextOptions));
            $doc = new DomDocument;
            libxml_use_internal_errors(true);
            $doc->loadHtml($html);
            $xml2 = $doc->getElementsByTagName('table');
            var_dump($xml2);
            $xml = simplexml_load_string($doc->saveXML());
            //$htmlNodes = $doc->getElementById('myTable');
            /*
            foreach ($xml as $node) {
                foreach ($node->div as $key => $div1)
                {
                    foreach($div1->div as $key => $div2)
                    {
                        foreach($div2->form as $key => $div3)
                        {
                            foreach($div3->div as $key => $div4)
                            {
                                foreach($div4->div->div as $key => $div5)
                                {
                                    foreach($div5->div->div->table as $key => $div6)
                                    {
                                        foreach($div6->tbody->tr as $key => $div7)
                                        {
                                            foreach($div7->td as $key => $div8)
                                            {
                                                echo($div8);
                                                foreach($div8 as $key => $div9)
                                                {
                                                    var_dump($div9);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            */
            //echo "<pre>".$htmlNodes."</pre>";
        }
    }
}
