<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContractPourposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_purposes')->insert(['purpose' => 'Alimentação', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Arrendamento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Comodato', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Compra e Venda de Calçados de Segurança', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Compra e Venda de Postes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Compra e Venda de Imobilizado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Compra e Venda de Imóvel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Consultoria e Assessoria na Área de Manejo Integrado de Pragas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Contrato entre Empresas do Grupo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Controle Biologico de Lagartas Desfolhadoras em Eucalipto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Informática', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Locação de Motocicletas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Locação de Sistema de Monitoramento Florestal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Locação de Veículos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Monitoramento e Localização de Veículos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços Advocacia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços de Contabilidade', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços de Transporte Diversos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços Mecanizado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços Transporte de Pessoal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços Especializado Engenheiro Civil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_purposes')->insert(['purpose' => 'Prestação de Serviços Especializado Destinação de Resíduo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
