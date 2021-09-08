<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListProviderController;

class ListProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listprovider:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza campos do tipo lista MEC - Fornecedores do Smartquestion';

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
        $provider = new SQListProviderController;
        $provider->listProvider();
    }
}
