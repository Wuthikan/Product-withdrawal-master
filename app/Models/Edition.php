<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edition extends Model
{
    protected $table = 'dim_editions';
    public $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'image'
    ];
}
