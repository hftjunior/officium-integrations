<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert(['code' =>11, 'state' => 'Rondônia', 'initial' => 'RO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>12, 'state' => 'Acre', 'initial' => 'AC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>13, 'state' => 'Amazonas', 'initial' => 'AM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>14, 'state' => 'Roraima', 'initial' => '	RR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>15, 'state' => 'Pará', 'initial' => 'PA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>16, 'state' => 'Amapá', 'initial' => 'AP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>17, 'state' => 'Tocatins', 'initial' => 'TO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>21, 'state' => 'Maranhão', 'initial' => 'MA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>22, 'state' => 'Piauí', 'initial' => 'PI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>23, 'state' => 'Ceará', 'initial' => 'CE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>24, 'state' => 'Rio Grande do Norte', 'initial' => 'RN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>25, 'state' => 'Paraíba', 'initial' => 'PB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>26, 'state' => 'Pernambubo', 'initial' => 'PE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>27, 'state' => 'Alagoas', 'initial' => 'AL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>28, 'state' => 'Sergipe', 'initial' => 'SE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>29, 'state' => 'Bahia', 'initial' => 'BA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>31, 'state' => 'Minas Gerais', 'initial' => 'MG', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>32, 'state' => 'Espírito Santo', 'initial' => 'ES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>33, 'state' => 'Rio de Janeiro', 'initial' => 'RJ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>35, 'state' => 'São Paulo', 'initial' => 'SP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>41, 'state' => 'Paraná', 'initial' => 'PR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>42, 'state' => 'Santa Catarina', 'initial' => 'SC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>43, 'state' => 'Rio Grande do Sul', 'initial' => 'RS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>50, 'state' => 'Mato Grosso do Sul', 'initial' => 'MS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>51, 'state' => 'Mato Grosso', 'initial' => 'MT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>52, 'state' => 'Goiás', 'initial' => 'GO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('states')->insert(['code' =>53, 'state' => 'Distrito Federal', 'initial' => 'DF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

    }
}
