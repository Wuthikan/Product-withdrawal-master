<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;

class BundledCustomerTierPrices extends Model
{
    protected $table = 'bundled_customer_tier_prices';
    protected $fillable = [
        'id',
        'client_id',
        'bundled_product_id',
        'customer_tier_id',
        'price',
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];

    public function bundledProduct()
    {
        return $this->belongsTo(\DurianSoftware\Models\BundledProduct::class, 'bundled_product_id', 'id');
    }
}
