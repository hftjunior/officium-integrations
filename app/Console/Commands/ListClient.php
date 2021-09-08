<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListClientController;

class ListClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listclient:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza campos do tipo lista CAR - Clientes do Smartquestion';

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
        $client = new SQListClientController;
        $client->listClient();
    }
}
