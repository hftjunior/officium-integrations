<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpTransport extends Model
{
    protected $fillable = [
        'id',
        'aprovacao',
        'serie',
        'num_cem',
        'num_doc_ext_nf',
        'extra_01',
        'unidade_gestao',
        'id_regiao',
        'regiao',
        'projeto',
        'projeto2',
        'talhao_patio',
        'ordem_transporte',
        'data_emissao',
        'saida_fabrica',
        'inicio_carga',
        'fim_carga',
        'data_chegada_balanca',
        'data_saida_balanca',
        'inicio_descarga',
        'fim_descarga',
        'data_saida_patio',
        'data_vencimento',
        'localidade',
        'distancia',
        'empresa',
        'fornecedor',
        'tipo_conjunto',
        'cavalo_mecanico',
        'implementos',
        'carga_manual',
        'equip_carga',
        'fornecedor_carregamento',
        'quadra_pilha',
        'peso_bruto',
        'tara',
        'volume',
        'calculo_logmeter',
        'equip_descarga',
        'patio_destino',
        'entrega',
        'quadra_destino',
        'pilha_destino',
        'abrev_local_consumo',
        'duracao_ida',
        'tipo_produto_origem',
        'produto_origem',
        'tipo_produto_destino',
        'local_destino',
        'produto_pilha_destino',
        'registro',
        'origem_ponto_de_transferencia',
        'criado_por',
        'modificado_por',
        'ultima_atualizacao',
        'created_at',
        'updated_at',
        'import'
    ];
}