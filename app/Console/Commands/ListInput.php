<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListInputController;

class ListInput extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listinput:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualização da lista de insumos do Smartquestion';

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
        $input = new SQListInputController;
        $input->listInput();
    }
}
