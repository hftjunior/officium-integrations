<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContractTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->insert(['type' => 'Prestação de Serviços', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

    }
}
