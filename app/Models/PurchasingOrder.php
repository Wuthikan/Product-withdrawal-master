<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingOrder extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'dim_purchasing_orders';
    public $timestamps = true;
    protected $softDelete = true;
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
        'is_approve',
        'remark'
    ];

    public function purchasingOrderItem()
    {
        return $this->hasMany(PurchasingOrderItem::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function inquiryPurchasingOrders()
    {
        return $this->hasMany(InquiryPurchasingOrder::class);
    }

    public function documentDate()
    {
        return $this->belongsTo(Date::class, 'document_date_id');
    }

    public function dueDate()
    {
        return $this->belongsTo(Date::class, 'due_date_id');
    }

    public function shippingDate()
    {
        return $this->belongsTo(Date::class, 'shipping_date_id');
    }
}
