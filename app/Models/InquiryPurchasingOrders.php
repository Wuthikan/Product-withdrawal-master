<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InquiryPurchasingOrders extends Model
{
    use SoftDeletes;

    protected $table = 'inquiry_purchasing_orders';
    protected $fillable = [
        'id',
        'client_id',
        'inquiry_id',
        'purchasing_order_id',
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];
}
