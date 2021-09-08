<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectTractionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_tractions')->insert(['traction' => '4 x 2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_tractions')->insert(['traction' => '4 x 4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
