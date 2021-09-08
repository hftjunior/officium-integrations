<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListOperationController;

class ListOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listoperation:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza campos do tipo lista MEC - Operações em campo no SmartQuestion';

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
        $operation = new SQListOperationController;
        $operation->listOperation(); 
    }
}
