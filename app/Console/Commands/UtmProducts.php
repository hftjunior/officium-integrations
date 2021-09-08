<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Integration\TVUtmProductsController;

class UtmProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utm:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta das informações de Produtos da UTM no TOTVs e atualiza no Officium';

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
        $products = new TVUtmProductsController;
        $products->getProducts();
    }
}
