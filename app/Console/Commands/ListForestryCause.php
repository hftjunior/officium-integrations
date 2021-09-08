<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListForestryCauseController;

class ListForestryCause extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listforestrycause:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualização da lista de causas de reaplicação de insumo no Smartquestion';

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
        $cause = new SQListForestryCauseController;
        $cause->listForestryCause();
    }
}
