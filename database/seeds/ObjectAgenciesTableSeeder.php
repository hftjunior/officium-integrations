<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectAgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_agencies')->insert(['agency' => 'DETRAN (RENAVAM)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_agencies')->insert(['agency' => 'IEF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
