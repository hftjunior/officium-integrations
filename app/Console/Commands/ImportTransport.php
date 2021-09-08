<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Imports\TransportImport;
use Maatwebsite\Excel;

class ImportTransport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:transport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa informações de transport do SGF';

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
        $path = storage_path().'/app/public/';
        foreach (Storage::files('transport') as $filename) {
            $this->output->title('Starting import file: '.$filename);
            if(is_file($path.$filename)){
                (new TransportImport)->withOutput($this->output)->import($path.$filename);
                $this->output->success('Import successful.');
                unlink($path.$filename);
            }else{
                $this->output->error('File not found.');
            }
        }
    }
}
