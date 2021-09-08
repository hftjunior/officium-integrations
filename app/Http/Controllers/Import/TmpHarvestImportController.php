<?php

namespace App\Http\Controllers\Import;

use App\Imports\HarvestsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TmpHarvestImportController extends Controller
{
    public function import()
    {
        //Excel::import(new HarvestsImport, storage_path('import.xlsx'));
        (new HarvestsImport)->withOutput($this->output)->import(storage_path('import.xlsx'));
    }
}
