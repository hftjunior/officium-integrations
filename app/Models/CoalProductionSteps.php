<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalProductionSteps extends Model
{
    protected $table = 'coal_production_steps';
    protected $fillable = [
        'coal_production_id', 'coal_step_id', 'dtinitial', 'vol_wood', 'diameter_wood',
        'coal_stock_id', 'vol_charcoal', 'vol_atico'
    ];

    public function production()
    {
        return $this->belongsTo(CoalProduction::class);
    }

    public function step()
    {
        return $this->belongsTo(CoalStep::class);
    }

    public function stock()
    {
        return $this->belongsTo(CoalStock::class);
    }
}
