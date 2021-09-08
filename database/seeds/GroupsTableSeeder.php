<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name'          => 'Administradores',
            'slug'          => 'admin',
            'description'   => 'Administradores do sistema.',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
}
