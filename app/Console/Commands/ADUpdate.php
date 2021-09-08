<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\ADConsultController;

class ADUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ldap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de AD e ativa ou desativa usuários';

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
        $ldap = new ADConsultController;
        $ldap->updateLdap();
    }
}
