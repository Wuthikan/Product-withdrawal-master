<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingOrderItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'fact_purchasing_orders';
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [
        'client_id',
        'purchasing_order_id',
        'product_id',
        'publisher_id',
        'category_id',
        'platform_id',
        'edition_id',
        'region_id',
        'product_item_id',
        'unit_id',
        'product_item_barcodes_id',
        'warehouse_id',
        'product_type_id',
        'quantity',
        'currency_id',
        'price_per_unit',
        'discount_per_unit',
        'shipping_fee_per_unit',
        'import_duty_per_unit',
        'amount_before_vat_per_unit',
        'vat_per_unit',
        'amount_including_vat_per_unit',
        'sub_total_before_vat',
        'vat_sub_total',
        'sub_total_including_vat',
    ];

    public function purchasingOrder()
    {
        return $this->belongsTo(PurchasingOrder::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
