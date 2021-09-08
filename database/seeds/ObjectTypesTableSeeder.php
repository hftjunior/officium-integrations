<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_types')->insert(['type' => 'Máquina Agrícola', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_types')->insert(['type' => 'Veículo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_types')->insert(['type' => 'Implemento', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
