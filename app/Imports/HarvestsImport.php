<?php

namespace App\Imports;

use App\Models\TmpHarvests;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class HarvestsImport implements ToModel, WithProgressBar
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
        $register = TmpHarvests::where('id', '=', $row[0])->exists();
        if($register){
            return null;
        }

        // format date
        //$data1 = $row[66];
        echo "DATACTO: ".$row[66];
        echo " | DATAOPERACAO: ".$row[123];
        echo " | DATAHORAINICIO: ".$row[124];
        echo " | INICIOFIM: ".$row[125];
        echo " | REGISTRO: ".$row[155];

        if((strpos($row[66], '/')) || (strpos($row[123], '/')) || (strpos($row[124], '/')) || (strpos($row[155], '/')))
        {
            $dataCto = (!empty($row[66])) ? (new \DateTime(substr($row[66],6,4).'-'.substr($row[66],3,2).'-'.substr($row[66],0,2)))->format('Y-m-d') : null;
            //echo $dataCto;
            $dataOperacao = (!empty($row[124])) ? (new \DateTime(substr($row[124],6,4).'-'.substr($row[124],3,2).'-'.substr($row[124],0,2)))->format('Y-m-d') : null;
            //echo " | ".$dataOperacao;
            $dataHoraInicio = (!empty($row[125])) ? (new \DateTime(substr($row[125],6,4).'-'.substr($row[125],3,2).'-'.substr($row[125],0,2).' '.substr($row[125],11,5)))->format('Y-m-d H:i:s') : null;
            //echo " | ".$dataHoraInicio;
            $incioFim = (!empty($row[126])) ? (new \DateTime(substr($row[126],6,4).'-'.substr($row[126],3,2).'-'.substr($row[126],0,2).' '.substr($row[126],11,5)))->format('Y-m-d H:i:s') : null;
            //echo " | ".$incioFim;
            $dataRegistro = (!empty($row[155])) ? (new \DateTime(substr($row[155],6,4).'-'.substr($row[155],3,2).'-'.substr($row[155],0,2)))->format('Y-m-d') : null;
            //echo " | ".$dataRegistro;
        }
        else
        {
            $dataCto = (!empty($row[66])) ? Date::excelToDateTimeObject($row[66])->format('Y-m-d') : null;
            //echo $dataCto;
            $dataOperacao = (!empty($row[124])) ? Date::excelToDateTimeObject($row[124])->format('Y-m-d') : null;
            //echo " | ".$dataOperacao;
            $dataHoraInicio = (!empty($row[125])) ? Date::excelToDateTimeObject($row[125])->format('Y-m-d H:i:s') : null;
            //echo " | ".$incioFim;
            $incioFim = (!empty($row[126])) ? Date::excelToDateTimeObject($row[126])->format('Y-m-d H:i:s') : null;
            //echo " | ".$incioFim;
            $dataRegistro = (!empty($row[155])) ? Date::excelToDateTimeObject($row[155])->format('Y-m-d') : null;
            //echo " | ".$dataRegistro;
        }

        return new TmpHarvests([
            'id' => intval($row[0]),
            'cod_apontamento' => intval($row[1]),
            'boletim_origem' => intval($row[2]),
            'ref_boletin'  => $row[3],
            'boletin_producao'  => $row[4],
            'tipo_boletim'  => $row[5],
            'unidade_gestao'  => $row[6],
            'regiao'  => $row[7],
            'id_regiao'  => $row[8],
            'projeto'  => $row[10],
            'id_projeto'  => $row[11],
            'cod_uso_solo'  => $row[13],
            'talhao'  => $row[14],
            'uso_solo'  => $row[15],
            'declividade'  => $row[16],
            'cod_regime'  => $row[17],
            'regime'  => $row[18],
            'ciclo'  => $row[19],
            'rotacao'  => $row[20],
            'distancia'  => $row[21],
            'idade_inventario' => $row[23],
            'status_certificacao'  => $row[24],
            'idade_corte'  => $row[25],
            'densidade_basica'  => $row[26],
            'classificacao_densidade'  => $row[27],
            'arvores_ha'  => $row[28],
            'volume_arvore'  => $row[29],
            'volume_ha'  => $row[30],
            'colheita_programada'  => $row[31],
            'vlr_volume_ipc_talhao'  => $row[32],
            'volume_ipc'  => $row[33],
            'manejo'  => $row[34],
            'abrev_manejo'  => $row[35],
            'cod_tipo_produto'  => $row[37],
            'abrev_tipo_produto'  => $row[38],
            'tipo_produto'  => $row[39],
            'produto'  => $row[40],
            'id_produto'  => $row[41],
            'abrev_produto'  => $row[42],
            'descr_produto'  => $row[43],
            'produto_programado'  => $row[44],
            'id_produto_programado'  => $row[45],
            'descr_produto_programado'  => $row[46],
            'plano'  => $row[47],
            'abrev_plano'  => $row[48],
            'descr_plano'  => $row[49],
            'grupo_operacao'  => $row[50],
            'sequencia_grupo_oper'  => $row[51],
            'abrev_grupo_operacao'  => $row[52],
            'descr_grupo_operacao'  => $row[53],
            'grupo_operacao_ajustador'  => $row[54],
            'seq_grupo_operacao_ajustador'  => $row[55],
            'abrev_grupo_operacao_ajustador'  => $row[56],
            'descr_grupo_operacao_ajustador'  => $row[57],
            'atividade'  => $row[58],
            'abrev_atividade'  => $row[59],
            'descr_atividade'  => $row[60],
            'operacao'  => $row[61],
            'id_operacao'  => $row[62],
            'abrev_operacao'  => $row[63],
            'descr_operacao'  => $row[64],
            'cto'  => $row[65],
            'data_cto'  => $dataCto,
            'escala_rendimento'  => $row[67],
            'descr_escala_rendimento'  => $row[68],
            'tipo_parada'  => $row[69],
            'parada'  => $row[70],
            'id_parada'  => $row[71],
            'abrev_parada'  => $row[72],
            'descr_parada'  => $row[73],
            'flag_parada_maq_base'  => $row[74],
            'parada_mecanica'  => $row[75],
            'parada_operacional'  => $row[76],
            'parada_administrativa'  => $row[77],
            'parada_nao_definida'  => $row[78],
            'parada_programada'  => $row[79],
            'horas_trabalhadas'  => $row[80],
            'duracao'  => $row[81],
            'tipo_parada_cabecote'  => $row[83],
            'cod_parada_cabecote'  => $row[84],
            'descr_parada_cabecote'  => $row[85],
            'id_parada_cabecote'  => $row[86],
            'flag_parada_cabecote'  => $row[87],
            'ordem_servico'  => $row[88],
            'descr_orderm_servico'  => $row[89],
            'fornecedor'  => $row[90],
            'descr_fornecedor'  => $row[91],
            'agrupador_frente_operacao'  => $row[92],
            'abrev_fente_operacao'  => $row[93],
            'descr_frente_operacao'  => $row[94],
            'turno'  => $row[95],
            'descr_turno'  => $row[96],
            'abrev_turno'  => $row[97],
            'horario_inicio_turno'  => $row[98],
            'horario_fim_turno'  => $row[99],
            'horas_turno'  => $row[100],
            'letra_turno'  => $row[101],
            'descr_letra_turno'  => $row[102],
            'operador'  => $row[103],
            'descr_operador'  => $row[104],
            'matricula_operador'  => $row[105],
            'funcionario_digitador'  => $row[106],
            'abrev_classe_equipamento'  => $row[107],
            'familia_equipamento'  => $row[109],
            'abrev_familia_equipamento'  => $row[110],
            'descr_familia_equipamento'  => $row[111],
            'cod_equipamento'  => $row[112],
            'id_equipamento'  => $row[113],
            'equipamento'  => $row[114],
            'cd_cabecote'  => $row[115],
            'id_cabecote'  => $row[116],
            'descr_cabecote'  => $row[117],
            'horimetro_inicial'  => $row[118],
            'horimetro_final'  => $row[119],
            'hodometro_inicial'  => $row[120],
            'hodometro_final'  => $row[121],
            'cem'  => $row[122],
            'serie_cem'  => $row[123],
            'data_operacao'  => $dataOperacao,
            'data_hora_inicio'  => $dataHoraInicio,
            'incio_fim'  => $incioFim,
            'volume_apontado'  => $row[127],
            'volume_ajustado'  => $row[128],
            'volume_ajustado_periodo'  => $row[129],
            'volume_eficiencia'  => $row[130],
            'volume_om'  => $row[131],
            'producao'  => $row[132],
            'num_arvores'  => $row[133],
            'volume_hora'  => $row[134],
            'producao_hora'  => $row[135],
            'vol_hora_viagem'  => $row[136],
            'praca'  => $row[137],
            'operacao_anterior'  => $row[138],
            'id_operacao_anterior'  => $row[139],
            'descr_operacao_anterior'  => $row[140],
            'fornecedor_anterior'  => $row[141],
            'descr_fornecedor_anterior'  => $row[142],
            'produto_anterior'  => $row[143],
            'descr_produto_anterior'  => $row[144],
            'cod_praca'  => $row[145],
            'descr_processado'  => $row[146],
            'um_operacao'  => $row[147],
            'producao_secundaria'  => $row[148],
            'um_producao_secundaria'  => $row[149],
            'ocorrencia'  => $row[150],
            'genero'  => $row[151],
            'especie'  => $row[152],
            'observacao'  => $row[153],
            'processado'  => $row[154],
            'data_registro'  => $dataRegistro,
            'ativo'  => $row[156],
            'unidade'  => $row[157],
            'import' => 'N',
       ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}

