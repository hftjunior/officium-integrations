<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductMeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_measures')->insert(['measure' => 'CAIXA', 'initial' =>'CX', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'HORA', 'initial' =>'H', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'HECTARE', 'initial' =>'HA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'KILOGRAMA', 'initial' =>'KG', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'KILOGRAMA/TONELADA', 'initial' =>'KM/TN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'LITROS', 'initial' =>'L', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'METROS', 'initial' =>'M', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'METRO DE CARVAO', 'initial' =>'MDC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'MÊS', 'initial' =>'MES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'MILHEIRO', 'initial' =>'MIL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'METRO QUADRADO', 'initial' =>'M2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'MOTRO CÚBICO', 'initial' =>'M3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'PAR', 'initial' =>'PAR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'PEÇA', 'initial' =>'PC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'TONELADA', 'initial' =>'T', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'UNIDADE', 'initial' =>'UN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_measures')->insert(['measure' => 'HORA', 'initial' =>'H', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
