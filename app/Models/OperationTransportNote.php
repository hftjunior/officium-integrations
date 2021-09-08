<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationTransportNote extends Model
{
    protected $fillable = [
        'dtemission',
        'int_location_id_source',
        'person_related_id_source',
        'int_stock_location_id_source',
        'result_center_id_source',
        'int_location_id_destiny',
        'person_related_id_destiny',
        'int_stock_location_id_destiny',
        'result_center_id_destiny',
        'person_provider_id',
        'truck_plate',
        'trailer_plate',
        'net_weight',
        'gross_weight',
        'volume',
        'int_moviment_type_id',
        'product_id',
        'cfop',
        'notes_nf',
        'coal_dcf_id',
        'note_dcf',
        'sgf_id',
        'num_cem',
        'doc_number',
        'integration',
        'idmov'
    ];
}
