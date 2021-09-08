<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StreetTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('street_types')->insert(['initial' => 'AL', 'type' => 'Alameda', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AC', 'type' => 'Acesso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AD', 'type' => 'Adro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ERA', 'type' => 'Aeroporto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AT', 'type' => 'Alto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'A', 'type' => 'Área', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AE', 'type' => 'Área Especial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ART', 'type' => 'Artéria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ATL', 'type' => 'Atalho', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AV', 'type' => 'Avenida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'AV-CONT', 'type' => 'Avenida Contorno', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BX', 'type' => 'Baixa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BLO', 'type' => 'Balão', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BAL', 'type' => 'Balneário', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BC', 'type' => 'Beco', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BELV', 'type' => 'Belvedere', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BL', 'type' => 'Bloco', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BSQ', 'type' => 'Bosque', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BVD', 'type' => 'Boulevard', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'BCO', 'type' => 'Buraco', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'C', 'type' => 'Cais', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CALC', 'type' => 'Calçada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CAM', 'type' => 'Caminho', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CPO', 'type' => 'Campo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CAN', 'type' => 'Canal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CH', 'type' => 'Chácara', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CHAP', 'type' => 'Chapadão', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CIRC', 'type' => 'Circular', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'COL', 'type' => 'Colônia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CMP-VR', 'type' => 'Complexo Viário', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'COND', 'type' => 'Condomínio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CJ', 'type' => 'Conjunto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'COR', 'type' => 'Corredor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'CRG', 'type' => 'Córrego', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'DSC', 'type' => 'Descida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'DSV', 'type' => 'Desvio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'DT', 'type' => 'Distrito', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'EVD', 'type' => 'Elevada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ENT-PART', 'type' => 'Entrada Particular', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'EQ', 'type' => 'Entre Quadra', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ESC', 'type' => 'Escada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ESP', 'type' => 'Esplanada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ETC', 'type' => 'Estação', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ESTC', 'type' => 'Estacionamento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ETD', 'type' => 'Estádio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ETN', 'type' => 'Estância', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'EST', 'type' => 'Estrada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'EST-MUN', 'type' => 'Estrada Municipal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FAV', 'type' => 'Favela', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FAZ', 'type' => 'Fazenda', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FRA', 'type' => 'Feira', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FER', 'type' => 'Ferrovia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FNT', 'type' => 'Fonte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'FTE', 'type' => 'Forte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'GAL', 'type' => 'Galeria', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'GJA', 'type' => 'Granja', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'HAB', 'type' => 'Habitacional', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'IA', 'type' => 'Ilha', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'JD', 'type' => 'Jardim', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'JDE', 'type' => 'Jardinete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'LD', 'type' => 'Ladeira', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'LG', 'type' => 'Lago', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'LGA', 'type' => 'Lagoa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'LRG', 'type' => 'Largo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'LOT', 'type' => 'Loteamento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'MNA', 'type' => 'Marina', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'MOD', 'type' => 'Módulo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TEM', 'type' => 'Monte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'MRO', 'type' => 'Morro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'NUC', 'type' => 'Núcleo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PDA', 'type' => 'Parada', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PDO', 'type' => 'Paradouro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PAR', 'type' => 'Paralela', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PRQ', 'type' => 'Parque', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PSG', 'type' => 'Passagem', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PSC-SUB', 'type' => 'Passagem Subterrânea', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PSA', 'type' => 'Passarela', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PAS', 'type' => 'Passeio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PAT', 'type' => 'Pátio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PNT', 'type' => 'Ponta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PTE', 'type' => 'Ponte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PTO', 'type' => 'Porto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PC', 'type' => 'Praça', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PC-ESP', 'type' => 'Praça de Esportes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PR', 'type' => 'Praia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'PRL', 'type' => 'Prolongamento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'Q', 'type' => 'Quadra', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'QTA', 'type' => 'Quinta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'QTAS', 'type' => 'Rodo Ane	Quintas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RAM', 'type' => 'Ramal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RMP', 'type' => 'Rampa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'REC', 'type' => 'Recanto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RES', 'type' => 'Residencial', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RET', 'type' => 'Reta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RER', 'type' => 'Retiro', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RTN', 'type' => 'Retorno', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ROD-AN', 'type' => 'Rodo Anel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ROD', 'type' => 'Rodovia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'RTT', 'type' => 'Rotatória', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ROT', 'type' => 'Rótula', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'R', 'type' => 'Rua', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'R-LIG', 'type' => 'Rua de Ligação', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'R-PED', 'type' => 'Rua de Pedestre', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'SRV', 'type' => 'Servidão', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ST', 'type' => 'Setor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'SIT', 'type' => 'Sítio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'SUB', 'type' => 'Subida', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TER', 'type' => 'Terminal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TV', 'type' => 'Travessa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TV-PART', 'type' => 'Travessa Particular', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TRC', 'type' => 'Trecho', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TRV', 'type' => 'Trevo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TCH', 'type' => 'Trincheira', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'TUN', 'type' => 'Túnel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'UNID', 'type' => 'Unidade', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VAL', 'type' => 'Vala', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VLE', 'type' => 'Vale', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VRTE', 'type' => 'Variante', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VER', 'type' => 'Vereda', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'V', 'type' => 'Via', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'V-AC', 'type' => 'Via de Acesso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'V-PED', 'type' => 'Via de Pedestre', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'V-EVD', 'type' => 'Via Elevado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'V-EXP', 'type' => 'Via Expressa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VD', 'type' => 'Viaduto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VLA', 'type' => 'Viela', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'VL', 'type' => 'Vila', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('street_types')->insert(['initial' => 'ZIG-ZAG', 'type' => 'Zigue-Zague', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
