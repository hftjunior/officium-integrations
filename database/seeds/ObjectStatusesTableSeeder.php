<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjectStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('object_statuses')->insert(['status' => 'Ativo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('object_statuses')->insert(['status' => 'Inativo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
