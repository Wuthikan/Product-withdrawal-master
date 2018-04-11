<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class FactNonEssentialPurchasingOrder extends Model
{
    //

    use SoftDeletes;

    protected $table = "fact_non_essential_purchasing_orders";
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $softDelete = true;
    protected $dates = [];
    protected $fillable = [

        'client_id',
        'purchasing_order_id',
        'publisher_id',
        'category_id',
        'product_id',
        'product_item_id',
        'platform_id',
        'edition_id',
        'region_id',
        'region_id',
        'unit_id',
        'product_item_barcodes_id',
        'warehouse_id',
        'quantity',
        'currency_id',
        'price_per_unit',
        'discount_per_unit',
        'amount_before_vat_per_unit',
        'vat_per_unit',
        'amount_including_vat_per_unit',
        'sub_total_before_vat',
        'vat_sub_total',
        'sub_total_including_vat',


    ];
    public function unit()
    {
        return $this->hasOne('DurianSoftware\unit', 'id', 'unit_id');
    }

    public function product_item_barcodes()
    {
        return $this->hasOne('DurianSoftware\product_item_barcodes', 'id', 'product_item_barcodes_id');
    }

    public function warehouse()
    {
        return $this->hasOne('DurianSoftware\warehouse', 'id', 'warehouse_id');
    }

    public function currency()
    {
        return $this->hasOne('DurianSoftware\currency', 'id', 'currency_id');
    }

    
    public function platform()
    {
        return $this->hasOne('DurianSoftware\platform', 'id', 'platform_id');
    }
    public function edition()
    {
        return $this->hasOne('DurianSoftware\edition', 'id', 'edition_id');
    }
    public function region()
    {
        return $this->hasOne('DurianSoftware\region', 'id', 'region_id');
    }





    public function client()
    {
        return $this->hasOne('DurianSoftware\client', 'id', 'client_id');
    }


    public function purchasing_order()
    {
        return $this->belongsTo(\DurianSoftware\Models\NonEssentialPurchasingOrder::class, 'id', 'purchasing_order_id');
    }
    public function category()
    {
        return $this->hasOne('DurianSoftware\category', 'id', 'category_id');
    }
}
