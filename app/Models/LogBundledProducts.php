<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogBundledProducts extends Model
{
    use SoftDeletes;

    protected $table = 'log_bundled_products';
    protected $fillable = [
        'id',
        'client_id',
        'bundled_product_id',
        'date_id',
        'user_id',
        'action',
        'field_name',
        'value_before',
        'value_after'
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];
}
