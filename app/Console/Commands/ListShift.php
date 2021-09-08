<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQListShiftController;

class ListShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listshift:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza campos do tipo lista MEC - Turnos no SmartQuestion';

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
        $shift = new SQListShiftController;
        $shift->listShift(); 
    }
}
