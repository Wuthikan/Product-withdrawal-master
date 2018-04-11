<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use SoftDeletes;

    protected $table = 'dim_inquiries';
    protected $fillable = [
        'id',
        'client_id',
        'date_id',
        'inquiry_no',
        'company_id',
        'branch_id',
        'billing_address',
        'sub_district_id',
        'district_id',
        'province_id',
        'postcode_id',
        'total_quantity',
        'total_backlog',
        'is_approve',
        'approval_user_id',
        'remark'
    ];

    protected $hidden = [
        'timestamp', 'soft_delete',
    ];

    
    
    public function companies()
    {
        return $this->hasOne(\DurianSoftware\Models\Company::class, 'id', 'company_id');
    }

    /* Wait for date*/

    public function date()
    {
        return $this->hasOne(\DurianSoftware\Date::class, 'id', 'date_id');
    }

    /* Wait for branch*/
    public function branch()
    {
        return $this->hasOne(\DurianSoftware\Models\Branch::class, 'id', 'branch_id');
    }

    public function subDistrict()
    {
        return $this->hasOne(\DurianSoftware\Models\SubDistrict::class, 'id', 'sub_district_id');
    }

    public function district()
    {
        return $this->hasOne(\DurianSoftware\Models\District::class, 'id', 'district_id');
    }

    public function province()
    {
        return $this->hasOne(\DurianSoftware\Models\Province::class, 'id', 'province_id');
    }

    public function postcode()
    {
        return $this->hasOne(\DurianSoftware\Models\PostalCode::class, 'id', 'postcode_id');
    }
}
