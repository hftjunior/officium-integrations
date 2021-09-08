<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectNoteMeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_note_measures')->insert(['measure' => 'HECTARES', 'initial' =>'HA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
