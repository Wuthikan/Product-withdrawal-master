<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FactInquiries extends Model
{
    use SoftDeletes;

    protected $table = 'fact_inquiries';
    protected $fillable = [
        'id',
        'client_id',
        'date_id',
        'inquiry_id',
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
        'unit_price',
        'amount',
        'remark'
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];
}
