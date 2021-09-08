<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListForestryManpowerTypeController;

class ListForestryManpowerType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listforestrymanpower:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualização da lista de tipo de mão-de-obra no Smartquestion';

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
        $type = new SQListForestryManpowerTypeController;
        $type->listForestryManpowerType();
    }
}
