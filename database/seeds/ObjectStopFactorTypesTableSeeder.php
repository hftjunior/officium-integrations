<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectStopFactorTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_stop_factor_types')->insert(['type' => 'PRODUTIVO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_stop_factor_types')->insert(['type' => 'IMPRODUTIVO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_stop_factor_types')->insert(['type' => 'AUXILIAR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
