<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Import\TransportNoteController;

class ImportTransportNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:transportnote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa dados da tabela temporária de transporte';

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
        $import = new TransportNoteController;
        $import->import();
    }
}
