<?php

use Illuminate\Database\Seeder;

class UserHasGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_has_groups')->insert([
            'user_id'       => 1,
            'group_id'      => 1          
        ]);
    }
}
