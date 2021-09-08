<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Import\TmpHarverstConvertDateController;

class ConvertDateHarvests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:dateharvests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converte data excel para data mysql';

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
        $convert = new TmpHarverstConvertDateController;
        $convert->convert();
    }
}
