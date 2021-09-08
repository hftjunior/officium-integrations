<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\WSLoadingNFCeController;

class LoadNFCeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:nfce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de NFCe';

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
        $nfce = new WSLoadingNFCeController;
        $nfce->getData();
    }
}
