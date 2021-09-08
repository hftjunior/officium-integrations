<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert(['category' => 'MATERIAIS DE ESCRITÓRIO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MATERIAIS DE INFORMÁTICA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'SERVIÇOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MOVEIS/ELETROS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MATERIAIS DE LIMPEZA / DESCARTÁVEIS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'ALIMENTAÇÃO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MATERIAL DE CONSTRUÇÃO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'FERRAMENTAS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'SEGURANÇA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MATERIAIS DIVERSOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'INSUMOS PARA POSTES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MUDAS E SEMENTES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'MATERIAIS DE CAMPO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'UTENSILIOS PARA ALOJAMENTO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'COMBUSTÍVEIS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'LUBRIFICANTES', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'PEÇAS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('product_categories')->insert(['category' => 'INSTRUMENTOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
