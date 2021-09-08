<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'product', 'type', 'product_category_id',
        'product_measure_id', 'erp_code', 'status', 'conversion',
        'product_measure_id_conv', 'semi_finished'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function measure()
    {
        return $this->belongsTo(ProductMeasure::class, 'product_measure_id', 'id');
    }
}
