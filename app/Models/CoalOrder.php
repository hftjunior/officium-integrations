<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalOrder extends Model
{
    protected $table = 'coal_order';
    protected $fillable = [
        'coal_unit_id', 'person_client_id', 'dtemission', 'status',
        'coal_payment_id', 'charter', 'person_provider', 'amount', 'vlrunit',
        'coal_measure_id', 'note_nf', 'notes', 'codnat',
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }

    public function client()
    {
        return $this->belongsTo(PersonClient::class);
    }

    public function provider()
    {
        return $this->belongsTo(CoalProvider::class);
    }

    public function payment()
    {
        return $this->belongsTo(CoalPayment::class);
    }

    public function measure()
    {
        return $this->belongsTo(CoalMeasure::class);
    }
}
