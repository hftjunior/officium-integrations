<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonEmployeePaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_employee_payments')->insert(['payment' => 'Mensal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_employee_payments')->insert(['payment' => 'Semanal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('person_employee_payments')->insert(['payment' => 'Diário', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }
}
