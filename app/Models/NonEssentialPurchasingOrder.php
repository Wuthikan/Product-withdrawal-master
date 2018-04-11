<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class NonEssentialPurchasingOrder extends Model
{
    //
    use SoftDeletes;

    protected $table = "dim_non_essential_purchasing_orders";
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $softDelete = true;
    protected $dates = [];
    protected $fillable = [
            'client_id',
            'company_id',
            'branch_id',
            'billing_address',
            'sub_district_id',
            'district_id',
            'province_id',
            'postcode_id',
            'payment_conditions_credit_term_id',
            'document_date_id',
            'due_date_id',
            'shipping_date_id',
            'total_quantity',
            'backlog_quatity',
            'currency_id',
            'amount',
            'discount',
            'amount_before_vat',
            'vat',
            'grand_total',
            'approval_user_id',
            'remark'



    ];
    public function document_date()
    {
        return $this->hasOne('DurianSoftware\Models\day', 'id', 'document_date_id');
    }
    public function due_date()
    {
        return $this->hasOne('DurianSoftware\Models\day', 'id', 'due_date_id');
    }
    public function shipping_date()
    {
        return $this->hasOne('DurianSoftware\Models\day', 'id', 'shipping_date_id');
    }
    public function currency()
    {
        return $this->hasOne('DurianSoftware\Models\currency', 'id', 'currency_id');
    }
    public function sub_district()
    {
        return $this->hasOne('DurianSoftware\Models\sub_district', 'id', 'sub_district_id');
    }
    public function district()
    {
        return $this->hasOne('DurianSoftware\Models\district', 'id', 'district_id');
    }
    public function province()
    {
        return $this->hasOne('DurianSoftware\Models\province', 'id', 'province_id');
    }
    public function postcode()
    {
        return $this->hasOne('DurianSoftware\Models\postcode', 'id', 'postcode_id');
    }
    public function payment_conditions_credit_term()
    {
        return $this->hasOne('DurianSoftware\Models\payment_conditions_credit_term', 'id', 'payment_conditions_credit_term_id');
    }



    public function FactNonEssentialPurchasingOrders()
    {
        return $this->hasMany(\DurianSoftware\Models\FactNonEssentialPurchasingOrder::class, 'purchasing_order_id', 'id');
    }

    public function client()
    {
        return $this->hasOne('DurianSoftware\Models\client', 'id', 'client_id');
    }

    public function company()
    {
        return $this->hasOne('DurianSoftware\Models\company', 'id', 'company_id');
    }

    public function branch()
    {
        return $this->hasOne('DurianSoftware\Models\branch', 'id', 'branch_id');
    }
}
