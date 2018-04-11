<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Delatbabel\Elocrypt\Elocrypt;

class BundledProduct extends Model
{
    use SoftDeletes, Elocrypt;

    protected $table = 'dim_bundled_product';
    protected $fillable = [
        'id',
        'client_id',
        'bundled_name',
        'promotion_srp',
        'start_date_id',
        'end_date_id',
        'is_approve',
        'approval_user_id',
        'remark',
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];

    protected $encrypts = [
        // 'promotion_srp'
    ];

    /**
     * Searching the bundled product
     * @param  [type] $query  [description]
     * @param  [type] $fields [description]
     * @param  [type] $value  [description]
     * @return [type]         [description]
     */
    public function scopeLike($query, $fields, $value)
    {
        if (is_array($fields)) {
            $query->where($fields[0], 'LIKE', "%$value%");
            
            foreach (array_splice($fields, 1) as $field) {
                $query->orWhere($field, 'LIKE', "%$value%");
            }

            return $query;
        }

        return $query->where($fields, 'LIKE', "%$value%");
    }

    /**
     * FILTER WITH CLIENT_ID
     * @param  [type] $query [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    public function scopeCompany($query, $id)
    {
        return $query->where('client_id', $id);
    }

    public function user()
    {
        return $this->hasOne('DurianSoftware\User', 'id', 'approval_user_id');
    }

    public function startDate()
    {
        return $this->hasOne('DurianSoftware\Date', 'id', 'start_date_id');
    }

    public function endDate()
    {
        return $this->hasOne('DurianSoftware\Date', 'id', 'end_date_id');
    }

    public function bundledItems()
    {
        return $this->hasMany(\DurianSoftware\Models\BundledItems::class, 'bundled_product_id', 'id');
    }
}
