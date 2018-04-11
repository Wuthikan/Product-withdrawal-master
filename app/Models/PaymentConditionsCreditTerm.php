<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentConditionsCreditTerm extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $softDelete = true;
    protected $fillable = [
        'client_id',
        'company_id',
        'branch_id',
        'pay_affter_recieve_day',
        'currency_id',
        'pay_percent',
        'pay_amount_before_vat',
        'vat',
        'pay_amount_after_vat'
    ];
}
