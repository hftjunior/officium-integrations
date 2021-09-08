<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_categories')->insert(['category' => 'Cliente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_categories')->insert(['category' => 'Fornecedor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_categories')->insert(['category' => 'Colaborador', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);        
    }
}
