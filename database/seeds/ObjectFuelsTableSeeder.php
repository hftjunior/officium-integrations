<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectFuelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_fuels')->insert(['fuel' => 'Gasolina', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_fuels')->insert(['fuel' => 'Etanol', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_fuels')->insert(['fuel' => 'Óleo Diesel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_fuels')->insert(['fuel' => 'Gás Natural', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_fuels')->insert(['fuel' => 'Etanol / Gasolina', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
