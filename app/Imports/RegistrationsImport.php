<?php

namespace App\Imports;

use App\Models\TmpRegistration;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class RegistrationsImport implements ToModel, WithProgressBar
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //skippin row header
        if($row[0] == 'Id'){
            return null;
        }

        // format date
        if(strpos($row[21], '/'))
        {
            $dataPlantio = ($row[21]) ? (new \DateTime(substr($row[21],6,4).'-'.substr($row[21],3,2).'-'.substr($row[21],0,2)))->format('Y-m-d') : null;
        }
        elseif($row[21])
        {
            $dataPlantio = ($row[21]) ? Date::excelToDateTimeObject($row[21])->format('Y-m-d') : null;
        }
        else
        {
            $dataPlantio = null;
        }

        // registro
        if(strpos($row[55], '/'))
        {
            $registro = ($row[55]) ? (new \DateTime(substr($row[55],6,4).'-'.substr($row[55],3,2).'-'.substr($row[55],0,2)))->format('Y-m-d') : null;
        }
        elseif($row[55])
        {
            $registro = ($row[55]) ? Date::excelToDateTimeObject($row[55])->format('Y-m-d') : null;
        }
        else
        {
            $registro = null;
        }

        //checks if the record exists
        $register = TmpRegistration::where('sf_id', '=', $row[0])->first();
        if($register){
            $register->sf_id = intval($row[0]);
            $register->tipo_propriedade =  $row[1];
            $register->id_regiao = intval($row[2]);
            $register->regiao =  $row[3];
            $register->id_projeto = intval($row[4]);
            $register->projeto =  $row[5];
            $register->localidade =  $row[6];
            $register->talhao =  $row[7];
            $register->nro_ciclo = intval($row[8]);
            $register->nro_rotacao = intval($row[9]);
            $register->tipo =  $row[10];
            $register->feicao_pai =  $row[11];
            $register->descricao_de_uso_do_solo =  $row[12];
            $register->fase =  $row[13];
            $register->bacia =  $row[14];
            $register->solo =  $row[15];
            $register->relevo =  $row[16];
            $register->espacamento =  $row[17];
            $register->sistema_de_propagacao =  $row[18];
            $register->mat_genetico =  $row[19];
            $register->especie =  $row[20];
            $register->data_plantio =  $dataPlantio;
            $register->mes_de_plantio = intval($row[22]);
            $register->regime =  $row[23];
            $register->manejo =  $row[24];
            $register->sitio =  $row[25];
            $register->vlr_area =  $row[26];
            $register->area_gis =  $row[27];
            $register->atualizar_via_gis =  $row[28];
            $register->distancia_media_transporte_km =  $row[29];
            $register->distancia_media_baldeio =  $row[30];
            $register->situacao =  $row[31];
            $register->cd_uso_solo_pai = intval($row[32]);
            $register->planooperacao =  $row[33];
            $register->cd_projeto_investimento =  $row[34];
            $register->dcr_projeto_investimento =  $row[35];
            $register->cod_tarefa_proj_invest =  $row[36];
            $register->id_terra_potencial =  $row[37];
            $register->responsavel =  $row[38];
            $register->observacoes =  $row[39];
            $register->densidade_basica =  $row[40];
            $register->certificado_fsc =  $row[41];
            $register->n_notrato_bndes =  $row[42];
            $register->cr =  $row[43];
            $register->experimento =  $row[44];
            $register->nivel_subbosque =  $row[45];
            $register->projeto_microbacia =  $row[46];
            $register->grupo_de_tratamento =  $row[47];
            $register->responsavel_tecnico_plantio =  $row[48];
            $register->art_plantio =  $row[49];
            $register->identificador_pj =  $row[50];
            $register->cnpj =  $row[51];
            $register->desbaste =  $row[52];
            $register->bioma =  $row[53];
            $register->tipologia =  $row[54];
            $register->registro =  $registro;
            $register->ativo =  $row[56];
            $register->updated_at =  date('Y-m-d H:i:s');
            $register->save();
            return null;
        }

        return new TmpRegistration([
            "sf_id" => intval($row[0]),
            "tipo_propriedade" =>  $row[1],
            "id_regiao" => intval($row[2]),
            "regiao" =>  $row[3],
            "id_projeto" => intval($row[4]),
            "projeto" =>  $row[5],
            "localidade" =>  $row[6],
            "talhao" =>  $row[7],
            "nro_ciclo" => intval($row[8]),
            "nro_rotacao" => intval($row[9]),
            "tipo" =>  $row[10],
            "feicao_pai" =>  $row[11],
            "descricao_de_uso_do_solo" =>  $row[12],
            "fase" =>  $row[13],
            "bacia" =>  $row[14],
            "solo" =>  $row[15],
            "relevo" =>  $row[16],
            "espacamento" =>  $row[17],
            "sistema_de_propagacao" =>  $row[18],
            "mat_genetico" =>  $row[19],
            "especie" =>  $row[20],
            "data_plantio" =>  $dataPlantio,
            "mes_de_plantio" => intval($row[22]),
            "regime" =>  $row[23],
            "manejo" =>  $row[24],
            "sitio" =>  $row[25],
            "vlr_area" =>  $row[26],
            "area_gis" =>  $row[27],
            "atualizar_via_gis" =>  $row[28],
            "distancia_media_transporte_km" =>  $row[29],
            "distancia_media_baldeio" =>  $row[30],
            "situacao" =>  $row[31],
            "cd_uso_solo_pai" => intval($row[32]),
            "planooperacao" =>  $row[33],
            "cd_projeto_investimento" =>  $row[34],
            "dcr_projeto_investimento" =>  $row[35],
            "cod_tarefa_proj_invest" =>  $row[36],
            "id_terra_potencial" =>  $row[37],
            "responsavel" =>  $row[38],
            "observacoes" =>  $row[39],
            "densidade_basica" =>  $row[40],
            "certificado_fsc" =>  $row[41],
            "n_notrato_bndes" =>  $row[42],
            "cr" =>  $row[43],
            "experimento" =>  $row[44],
            "nivel_subbosque" =>  $row[45],
            "projeto_microbacia" =>  $row[46],
            "grupo_de_tratamento" =>  $row[47],
            "responsavel_tecnico_plantio" =>  $row[48],
            "art_plantio" =>  $row[49],
            "identificador_pj" =>  $row[50],
            "cnpj" =>  $row[51],
            "desbaste" =>  $row[52],
            "bioma" =>  $row[53],
            "tipologia" =>  $row[54],
            "registro" =>  $registro,
            "ativo" =>  $row[56],
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  date('Y-m-d H:i:s'),
       ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
