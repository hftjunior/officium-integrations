<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContractMeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_measures')->insert(['measure' => 'Hectares', 'initial' => 'ha', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_measures')->insert(['measure' => 'Kilometros', 'initial' => 'km', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_measures')->insert(['measure' => 'Hora Homem', 'initial' => 'hh', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('contract_measures')->insert(['measure' => 'Mensal', 'initial' => 'mes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
