<?php

namespace App\Imports;

use App\Models\TmpTransport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class TransportImport implements ToModel, WithProgressBar
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

        //checks if the record exists
        $register = TmpTransport::where('id', '=', $row[0])->exists();
        if($register){
            return null;
        }

        // format date
        if(strpos($row[13], '/'))
        {
            $dataEmissao = ($row[13]) ? (new \DateTime(substr($row[13],6,4).'-'.substr($row[13],3,2).'-'.substr($row[13],0,2).' '.substr($row[13],11,5)))->format('Y-m-d H:i:s') : null;
            $saidaFabrica = ($row[14]) ? (new \DateTime(substr($row[14],6,4).'-'.substr($row[14],3,2).'-'.substr($row[14],0,2).' '.substr($row[14],11,5)))->format('Y-m-d H:i:s') : null;
            $inicioCarga = ($row[15]) ? (new \DateTime(substr($row[15],6,4).'-'.substr($row[15],3,2).'-'.substr($row[15],0,2).' '.substr($row[15],11,5)))->format('Y-m-d H:i:s') : null;
            $fimCarga = ($row[16]) ? (new \DateTime(substr($row[16],6,4).'-'.substr($row[16],3,2).'-'.substr($row[16],0,2).' '.substr($row[16],11,5)))->format('Y-m-d H:i:s') : null;
            $dataChegadaBalanca = ($row[17]) ? (new \DateTime(substr($row[17],6,4).'-'.substr($row[17],3,2).'-'.substr($row[17],0,2).' '.substr($row[17],11,5)))->format('Y-m-d H:i:s') : null;
            $dataSaidaBalanca = ($row[18]) ? (new \DateTime(substr($row[18],6,4).'-'.substr($row[18],3,2).'-'.substr($row[18],0,2).' '.substr($row[18],11,5)))->format('Y-m-d H:i:s') : null;
            $inicioDescarga = ($row[19]) ? (new \DateTime(substr($row[19],6,4).'-'.substr($row[19],3,2).'-'.substr($row[19],0,2).' '.substr($row[19],11,5)))->format('Y-m-d H:i:s') : null;
            $fimDescarga = ($row[20]) ? (new \DateTime(substr($row[20],6,4).'-'.substr($row[20],3,2).'-'.substr($row[20],0,2).' '.substr($row[20],11,5)))->format('Y-m-d H:i:s') : null;
            $dataSaidaPatio = ($row[21]) ? (new \DateTime(substr($row[21],6,4).'-'.substr($row[21],3,2).'-'.substr($row[21],0,2).' '.substr($row[21],11,5)))->format('Y-m-d H:i:s') : null;
            $dataVencimento = ($row[22]) ? (new \DateTime(substr($row[22],6,4).'-'.substr($row[22],3,2).'-'.substr($row[22],0,2).' '.substr($row[22],11,5)))->format('Y-m-d H:i:s') : null;
            $registro = ($row[50]) ? (new \DateTime(substr($row[50],6,4).'-'.substr($row[50],3,2).'-'.substr($row[50],0,2).' '.substr($row[50],11,5)))->format('Y-m-d H:i:s') : null;
            $ultimaAtualizacao = ($row[54]) ? (new \DateTime(substr($row[54],6,4).'-'.substr($row[54],3,2).'-'.substr($row[54],0,2).' '.substr($row[54],11,5)))->format('Y-m-d H:i:s') : null;

        }
        else
        {
            $dataEmissao = ($row[13]) ? Date::excelToDateTimeObject($row[13])->format('Y-m-d H:i:s') : null;
            $saidaFabrica = ($row[14]) ? Date::excelToDateTimeObject($row[14])->format('Y-m-d H:i:s') : null;
            $inicioCarga = ($row[15]) ? Date::excelToDateTimeObject($row[15])->format('Y-m-d H:i:s') : null;
            $fimCarga = ($row[16]) ? Date::excelToDateTimeObject($row[16])->format('Y-m-d H:i:s') : null;
            $dataChegadaBalanca = ($row[17]) ? Date::excelToDateTimeObject($row[17])->format('Y-m-d H:i:s') : null;
            $dataSaidaBalanca = ($row[18]) ? Date::excelToDateTimeObject($row[18])->format('Y-m-d H:i:s') : null;
            $inicioDescarga = ($row[19]) ? Date::excelToDateTimeObject($row[19])->format('Y-m-d H:i:s') : null;
            $fimDescarga = ($row[20]) ? Date::excelToDateTimeObject($row[20])->format('Y-m-d H:i:s') : null;
            $dataSaidaPatio = ($row[21]) ? Date::excelToDateTimeObject($row[21])->format('Y-m-d H:i:s') : null;
            $dataVencimento = ($row[22]) ? Date::excelToDateTimeObject($row[22])->format('Y-m-d H:i:s') : null;
            $registro = ($row[50]) ? Date::excelToDateTimeObject($row[50])->format('Y-m-d H:i:s') : null;
            $ultimaAtualizacao = ($row[54]) ? Date::excelToDateTimeObject($row[54])->format('Y-m-d H:i:s') : null;

        }

        return new TmpTransport([
            'id' => intval($row[0]),
            'aprovacao' => $row[1],
            'serie' => $row[2],
            'num_cem' => intval($row[3]),
            'num_doc_ext_nf' => $row[4],
            'extra_01' => $row[5],
            'unidade_gestao' => $row[6],
            'id_regiao' => intval($row[7]),
            'regiao' => $row[8],
            'projeto' => $row[9],
            'projeto2' => $row[10],
            'talhao_patio' => $row[11],
            'ordem_transporte' => $row[12],
            'data_emissao' => $dataEmissao,
            'saida_fabrica' => $saidaFabrica,
            'inicio_carga' => $inicioCarga,
            'fim_carga' => $fimCarga,
            'data_chegada_balanca' => $dataChegadaBalanca,
            'data_saida_balanca' => $dataSaidaBalanca,
            'inicio_descarga' => $inicioDescarga,
            'fim_descarga' => $fimDescarga,
            'data_saida_patio' => $dataSaidaPatio,
            'data_vencimento' => $dataVencimento,
            'localidade' => $row[23],
            'distancia' => intval($row[24]),
            'empresa' => $row[25],
            'fornecedor' => $row[26],
            'tipo_conjunto' => $row[27],
            'cavalo_mecanico' => $row[28],
            'implementos' => $row[29],
            'carga_manual' => $row[30],
            'equip_carga' => $row[31],
            'fornecedor_carregamento' => $row[32],
            'quadra_pilha' => $row[33],
            'peso_bruto' => $row[34],
            'tara' => $row[35],
            'volume' => $row[36],
            'calculo_logmeter' => $row[37],
            'equip_descarga' => $row[38],
            'patio_destino' => $row[39],
            'entrega' => $row[40],
            'quadra_destino' => $row[41],
            'pilha_destino' => $row[42],
            'abrev_local_consumo' => $row[43],
            'duracao_ida' => intval($row[44]),
            'tipo_produto_origem' => $row[45],
            'produto_origem' => $row[46],
            'tipo_produto_destino' => $row[47],
            'local_destino' => $row[48],
            'produto_pilha_destino' => $row[49],
            'registro' => $registro,
            'origem_ponto_de_transferencia' => $row[51],
            'criado_por' => $row[52],
            'modificado_por' => $row[53],
            'ultima_atualizacao' => $ultimaAtualizacao,
            'import' => 'N',
       ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
