<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "dim_product_types";
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [
        'client_id',
        'name'
    ];
}
