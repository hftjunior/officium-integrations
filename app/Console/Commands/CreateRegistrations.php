<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SFRegistrationController;

class CreateRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:registrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar dados de informações do Cadastro Florestal a partir do SGF.';

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
        $registrations = new SFRegistrationController;
        $registrations->createdRegistrations();
    }
}
