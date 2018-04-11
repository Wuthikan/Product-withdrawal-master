<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InquiryPurchasingOrder extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [
        'client_id',
        'inquiry_id',
        'purchasing_order_id'
    ];
}
