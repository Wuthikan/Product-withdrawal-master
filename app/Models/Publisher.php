<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    protected $table = 'dim_publishers';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $softDelete = true;

    public $fillable = [
        'name',
        'description',
        'status'
    ];
}
