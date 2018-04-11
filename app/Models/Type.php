<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    protected $table = "dim_type";
    public $primaryKey = 'id';

    protected $fillable = ['type'];
}
