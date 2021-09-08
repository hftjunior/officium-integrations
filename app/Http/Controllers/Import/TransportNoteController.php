<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\TmpTransport;
use App\Models\IntRegion;
use App\Models\IntProject;
use App\Models\IntLocation;
use App\Models\IntStockLocation;
use App\Models\Objects;
use App\Models\Operation;
use App\Models\OperationTransportNote;
use App\Models\IntMovimentType;
use App\Models\CoalDcf;
use App\Models\CoalDcfLocation;

class TransportNoteController extends Controller
{
    public function import()
    {
        $transports = TmpTransport::where('import', '=', 'N')->get();
        foreach($transports as $transport){
            $dtemission = $transport->data_emissao;
            //echo "DTEMISSAO: ".$dtemission." | ";

            $stmRegionSource = IntRegion::where('sgf_id', '=', $transport->id_regiao)->first();
            $region_id_source = ($stmRegionSource) ? $stmRegionSource->id : 0;
            //echo "REGIAO ORIGEM: ".$region_id_source." | ";

            $stmProjectSource = IntProject::where('sgf_id', '=', $transport->projeto)->first();
            $project_id_source = ($stmProjectSource) ? $stmProjectSource->id : 0;
            //echo "PROJETO ORIGEM: ".$project_id_source." | ";

            $stmLocationSource = IntLocation::where('int_region_id', '=', $region_id_source)
                                    ->where('int_project_id', '=', $project_id_source)
                                    ->where('location', '=', $transport->talhao_patio)
                                    ->first();
            $int_location_id_source = ($stmLocationSource) ? $stmLocationSource->id : 0;
            //echo "LOCAL ORIGEM: ".$int_location_id_source." | ";


            $stmStockLocationSource = IntStockLocation::where('int_location_id', '=', $int_location_id_source)->first();
            if($stmStockLocationSource){
                $person_related_id_source = $stmStockLocationSource->person_related_id;
                //echo "COLIGADA ORIGEM: ".$person_related_id_source." | ";

                $int_stock_location_source = $stmStockLocationSource->id;
                //echo "LOCAL DE ESTOQUE ORIGEM: ".$int_stock_location_source." | ";

                $result_center_id_source = $stmStockLocationSource->result_center_id;
                //echo "CR ORIGEM ID: ".$result_center_id_source." | ";

                $cr_source = $stmStockLocationSource->resultCenter->code;
                //echo "CR ORIGEM: ".$cr_source." | ";

                $filialSource = $stmStockLocationSource->codfilial;
                //echo "FILIAL ORIGEM:".$filialSource." | ";;
            }else {
                $person_related_id_source = 0;
                //echo "COLIGADA ORIGEM: ".$person_related_id_source." | ";

                $int_stock_location_source = 0;
                //echo "LOCAL DE ESTOQUE ORIGEM: ".$int_stock_location_source." | ";

                $result_center_id_source = 0;
                //echo "CR ORIGEM ID: ".$result_center_id_source." | ";

                $cr_source = 0;
                //echo "CR ORIGEM: ".$cr_source." | ";

                $filialSource = 0;
                //echo "FILIAL ORIGEM:".$filialSource." | ";;
            }

            $stmLocationDestiny = IntLocation::where('location', '=', $transport->local_destino)
                                    ->first();
            $int_location_id_destiny = ($stmLocationDestiny) ? $stmLocationDestiny->id : 0;
            //echo "LOCAL DESTINO: ".$int_location_id_destiny." | ";

            $stmStockLocationDestiny = IntStockLocation::where('int_location_id', '=', $int_location_id_destiny)->first();
            if($stmStockLocationDestiny){
                $person_related_id_destiny = $stmStockLocationDestiny->person_related_id;
                //echo "COLIGADA DESTINO: ".$person_related_id_destiny." | ";

                $int_stock_location_destiny = $stmStockLocationDestiny->id;
                //echo "LOCAL DE ESTOQUE DESTINO: ".$int_stock_location_destiny." | ";

                $result_center_id_destiny = $stmStockLocationDestiny->result_center_id;
                //echo "CR DESTINO ID: ".$result_center_id_destiny." | ";

                $cr_destiny = $stmStockLocationDestiny->resultCenter->code;
                //echo "CR DESTINO: ".$cr_destiny." | ";

                $filialDestiny = $stmStockLocationDestiny->codfilial;
                //echo "FILIAL DESTINO:".$filialDestiny." | ";;
            }else {
                $person_related_id_destiny = 0;
                //echo "COLIGADA DESTINO: ".$person_related_id_destiny." | ";

                $int_stock_location_destiny = 0;
                //echo "LOCAL DE ESTOQUE DESTINO: ".$int_stock_location_destiny." | ";

                $result_center_id_destiny = 0;
                //echo "CR DESTINO: ".$result_center_id_destiny." | ";

                $cr_destiny = 0;
                //echo "CR DESTINO: ".$cr_destiny." | ";

                $filialDestiny = 0;
                //echo "FILIAL DESTINO:".$filialDestiny." | ";;
            }

            $plate = explode(" / ", $transport->cavalo_mecanico);
            $truck_plate = $plate[0];
            //echo "PLACA CAVALO: ".$truck_plate[0]. " | ";

            $trailer_plate = $transport->implementos;
            //echo "PLACA CARRETA: ".$trailer_plate. " | ";

            $stmObject = Objects::where('code', '=', $truck_plate)->first();
            if($stmObject){
                if($stmObject->owner->provider){
                    $person_provider_id = $stmObject->owner->provider->id;
                    //echo "FORNECEDOR: ".$person_provider_id." | ";
                }else {
                    $person_provider_id = 0;
                    //echo "FORNECEDOR: ".$person_provider_id." | ";
                }

            }else{
                $person_provider_id = 0;
                //echo "FORNECEDOR: ".$person_provider_id." | ";
            }

            $net_weight = $transport->peso_bruto - $transport->tara;
            //echo "PESO LIQUIDO: ".$net_weight. " | ";

            $gross_weight = $transport->peso_bruto;
            //echo "PESO BRUTO: ".$gross_weight. " | ";

            $volume = $transport->volume;
            //echo "VOLUME: ".$volume. " | ";

            $sgf_id = $transport->id;
            //echo "SGFID: ".$sgf_id." | ";

            $num_cem = $transport->num_cem;
            //echo "NUM CEM: ".$num_cem." | ";

            $doc_number = $transport->num_cem;
            //$doc_number = $transport->num_doc_ext_nf;
            //echo "DOC NUM: ".$doc_number." | ";

            $stmCoalDcf = CoalDcfLocation::where('int_location_id', '=', $int_location_id_source)->get();
            $coal_dcf_id = null;
            $note_dcf = '';
            if($stmCoalDcf){
                foreach ($stmCoalDcf as $dcf){
                    if($dcf->coalDcf->active == 'S' && $dcf->balance_wood > $volume){
                        $coal_dcf_id = $dcf->coalDcf->id;
                        $note_dcf = '';
                        $updateCoalDcfLocation = CoalDcfLocation::find($dcf->id);
                        $updateCoalDcfLocation->balance_wood = $dcf->balance_wood - $volume;
                        $updateCoalDcfLocation->save();
                        //echo "DCF ID: ".$coal_dcf_id;
                        continue;
                    }else {
                        $coal_dcf_id = null;
                        $note_dcf = 'SALDO DE DCF INSUFICIENTE PARA ESTE LOCAL DE ORIGEM.';
                        //echo "DCF ID: ".$coal_dcf_id;
                    }
                }
            }else {
                $coal_dcf_id = null;
                //echo "DCF ID: ".$coal_dcf_id;
                $note_dcf = 'DCF NÃO REGISTRADO PARA ESTE LOCAL DE ORIGEM.';
            }

            $stmOperation = Operation::where('sgf_id', '=', '4001')->first();
            $operation_id = ($stmOperation) ? $stmOperation->id : 0;
            //echo "OPERATION: ".$operation_id." | ";

            if($person_related_id_source == $person_related_id_destiny && $filialSource == $filialDestiny){
                $moviment = '3.1.80';
                $cfop = '';
                $notes_nf = '';
            }else if($cr_source == '00206' || $cr_source == '00208'){
                $moviment = '2.1.95';
                $cfop = '';
                $notes_nf = '';
            }else{
                $moviment = '2.2.88';
                $cfop = '5.151.02';
                $notes_nf = 'MADEIRA ORIUNDA DE FLORESTAS PLANTADAS - ICMS SOBRE FRETE ISENTO CONFORME ITEM 144, ANEXO I DO RICMS/02.- DISPENSADO RECOLHIMENTO DE TAXA FLORESTAL NOS TERMOS DO ART. 59-A DA LEI 4.747, DE 09 DE MAIO DE 1968 - PLACAS: :CARRETA - DCF: :DCF - OC: :OC';
            }
            //echo "MOVIMENTO: ".$moviment." | ";
            //echo "CFOP: ".$cfop." | ";
            //echo "OBS. NF: ".$notes_nf." | ";

            $stmMoviment = IntMovimentType::where('code', '=', $moviment)->first();
            $int_moviment_type_id = $stmMoviment->id;
            //echo "MOVIMENTO ID: ".$int_moviment_type_id." | ";

            $product_id = $stmMoviment->product_id;
            //echo "PRODUTO ID: ".$product_id." | ";

            //echo "\n";

            try{
                $operationTransportNote = OperationTransportNote::create([
                    "dtemission" => $dtemission,
                    "int_location_id_source" => $int_location_id_source,
                    "person_related_id_source" => $person_related_id_source,
                    "int_stock_location_id_source" => $int_stock_location_source,
                    "result_center_id_source" => $result_center_id_source,
                    "int_location_id_destiny" => $int_location_id_destiny,
                    "person_related_id_destiny" => $person_related_id_destiny,
                    "int_stock_location_id_destiny" => $int_stock_location_destiny,
                    "result_center_id_destiny" => $result_center_id_destiny,
                    "person_provider_id" => $person_provider_id,
                    "truck_plate" => $truck_plate,
                    "trailer_plate" => $trailer_plate,
                    "net_weight" => $net_weight,
                    "gross_weight" => $gross_weight,
                    "volume" => $volume,
                    "int_moviment_type_id" => $int_moviment_type_id,
                    "product_id" => $product_id,
                    "cfop" => $cfop,
                    "notes_nf" => $notes_nf,
                    "coal_dcf_id" => $coal_dcf_id,
                    "note_dcf" => $note_dcf,
                    "sgf_id" => $sgf_id,
                    "num_cem" => $num_cem,
                    "doc_number" => $doc_number,
                    "integration" => 'N',
                ]);

                $updateTmpTransport = TmpTransport::find($sgf_id);
                $updateTmpTransport->import = 'S';
                $updateTmpTransport->save();

            }catch(\Illuminate\Database\QueryException $e){
                echo "Boletim: ".$sgf_id." não importado.".$e."\n";
                continue;

            }catch(Exception $e){
                echo $e;
                continue;
            }
        }
    }
}
