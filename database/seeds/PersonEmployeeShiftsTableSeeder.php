<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonEmployeeShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_employee_shifts')->insert(['shift' => 'Diário', 'input' => '07:00:00', 'output' => '16:28:00', 'interval' => '01:00:00', 'weekhours' => '08:28:00', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        
    }
}
