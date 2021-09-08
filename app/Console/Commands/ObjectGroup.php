<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\SQObjectGroupController;

class ObjectGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'objectgroup:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o Grupo Ponto de Atendimento no Smartquestion';

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
        $group = new SQObjectGroupController;
        $group->objectGroup();
    }
}
