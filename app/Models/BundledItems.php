<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;

class BundledItems extends Model
{
    protected $table = 'bundled_items';
    protected $fillable = [
        'id',
        'client_id',
        'bundled_product_id',
        'product_item_id',
        'quantity',
        'product_id',
        'product_srp',
        'region_id',
        'platfrom_id',
        'edition_id',
        'category_id',
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];

    public function bundledProduct()
    {
        return $this->belongsTo(\DurianSoftware\Models\BundledProduct::class, 'bundled_product_id', 'id');
    }
}
