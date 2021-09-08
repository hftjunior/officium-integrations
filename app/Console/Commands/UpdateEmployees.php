<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\TVEmployeesController;

class UpdateEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de Colaboradores no TOTVs e atualiza no Officium';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employees = new TVEmployeesController;
        $employees->getEmployees();
    }
}
