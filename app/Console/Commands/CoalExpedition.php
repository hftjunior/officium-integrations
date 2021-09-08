<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQCoalExpeditionController;

class CoalExpedition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coalexpedition:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de ORDER DE CARREGAMENTO coletados no Smartquestion';

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
        $coalExpedition = new SQCoalExpeditionController;
        $coalExpedition->coalExpeditions();
    }
}
