<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMeasure extends Model
{
    protected $fillable = [
        'measure', 'initial'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_measure_id', 'id');
    }
}
