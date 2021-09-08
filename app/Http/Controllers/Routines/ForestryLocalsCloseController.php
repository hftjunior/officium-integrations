<?php

namespace App\Http\Controllers\Routines;

use DateTime;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Models\ForestryNoteLocal;
use App\Models\ForestryNote;

class ForestryLocalsCloseController extends Controller
{
    public function closeLocals()
    {
        $locals = ForestryNoteLocal::join('forestry_notes', 'forestry_note_locals.forestry_note_id', '=', 'forestry_notes.id')
                                   ->where('forestry_note_locals.close', '=', 'S')
                                   ->select(['forestry_note_locals.id as forestry_note_local_id',
                                             'forestry_note_locals.int_location_id as int_location_id',
                                             'forestry_notes.operation_id as operation_id'])
                                    ->get();

        if($locals)
        {
            foreach($locals as $item)
            {
                echo $item->forestry_note_local_id;
                $locationId = $item->int_location_id;
                $operationId = $item->operation_id;

                $closes = ForestryNoteLocal::join('forestry_notes', 'forestry_note_locals.forestry_note_id', '=', 'forestry_notes.id')
                                          ->where('forestry_notes.operation_id', '=', $operationId)
                                          ->where('forestry_note_locals.int_location_id', '=', $locationId)
                                          ->select(['forestry_note_locals.id as forestry_note_locals_id'])
                                          ->get();
                if($closes)
                {
                    $uniqid = uniqid();
                    foreach($closes as $close)
                    {
                        var_dump($close->forestry_note_locals_id);
                        $update = ForestryNoteLocal::find($close->forestry_note_locals_id);
                        $update->close = 'S';
                        $update->uniqid = $uniqid;
                        $update->save();
                    }
                }
            }
        }
    }
}
