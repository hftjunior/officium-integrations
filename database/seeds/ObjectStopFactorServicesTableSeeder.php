<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectStopFactorServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_stop_factor_services')->insert(['service' => 'SILVICULTURA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_stop_factor_services')->insert(['service' => 'UTM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_stop_factor_services')->insert(['service' => 'VIVEIRO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
