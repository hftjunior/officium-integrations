<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalExpedition extends Model
{
    protected $fillable = [
        'coal_order_id', 'coal_unit_id', 'coal_stock_id', 'result_center_id', 'dtexpedition', 'person_client_id',
        'person_provider_id', 'charter', 'person_employees_id', 'cpf', 'cnh', 'truck_plate', 'truck_antt', 'trailer_plate',
        'trailer_antt', 'net_weight', 'gross_weight', 'amount', 'coal_measure_id', 'volume', 'vlrunit', 'notes', 'code',
        'seal', 'antt',
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }

    public function stock()
    {
        return $this->belongsTo(CoalStock::class);
    }

    public function client()
    {
        return $this->belongsTo(PersonClient::class);
    }

    public function provider()
    {
        return $this->belongsTo(CoalProvider::class);
    }
}
