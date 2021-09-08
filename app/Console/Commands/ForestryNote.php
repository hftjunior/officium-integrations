<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQForestryNoteController;

class ForestryNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forestrynote:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de CROCI do Smartquestion';

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
        $forestryNote = new SQForestryNoteController;
        $forestryNote->forestryNote();
    }
}
