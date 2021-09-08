<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonDocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_document_types')->insert(['type' => 'PIS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_types')->insert(['type' => 'CTPS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_types')->insert(['type' => 'PIS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_types')->insert(['type' => 'CNH', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_types')->insert(['type' => 'RG', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
