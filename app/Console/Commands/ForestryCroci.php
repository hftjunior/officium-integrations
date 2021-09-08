<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\TVForestryNotesController;

class ForestryCroci extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:croci';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de CROCI do TOTVs';

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
        $forestryCroci = new TVForestryNotesController;
        $forestryCroci->getCroci();
    }
}
