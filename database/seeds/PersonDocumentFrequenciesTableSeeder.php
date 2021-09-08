<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonDocumentFrequenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_document_frequencies')->insert(['frequency' => 'Não se aplica', 'days' => 0, 'day' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Diário', 'days' => 1, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Semanal', 'days' => 7, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Quizenal', 'days' => 15, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Mensal', 'days' => 30, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Bimestral', 'days' => 60, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Trimestral', 'days' => 90, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Semestral', 'days' => 180, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_document_frequencies')->insert(['frequency' => 'Anual', 'days' => 365, 'day' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
