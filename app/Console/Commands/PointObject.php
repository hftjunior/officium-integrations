<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQObjectController;

class PointObject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pointobject:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria/Atualiza pontos de atendimento';

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
        $pointobject = new SQObjectController;
        $pointobject->pointObject();
    }
}
