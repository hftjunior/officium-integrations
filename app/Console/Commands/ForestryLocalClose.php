<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Routines\ForestryLocalsCloseController;

class ForestryLocalClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routine:localsclose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica o fechamento do talhao';

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
        $convert = new ForestryLocalsCloseController;
        $convert->closeLocals();
    }
}
