<?php

use Faker\Generator as Faker;

$factory->define(DurianSoftware\Models\PurchasingOrder::class, function (Faker $faker) {
    return [
        'client_id' =>  1,
        'company_id' => 1,
        'branch_id' => 1,
        'billing_address' => $faker->address,
        'sub_district_id' => 1,
        'district_id' => 1,
        'province_id' => 1,
        'postcode_id' => 1,
        'payment_conditions_credit_term_id' => 1,
        'document_date_id' => 1,
        'due_date_id' => 1,
        'shipping_date_id' => 1,
        'total_quantity' => 1,
        'backlog_quantity' => 1,
        'currency_id' => 1,
        'amount' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = null),
        'discount' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = null),
        'amount_before_vat' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = null),
        'vat' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = null),
        'grand_total' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = null),
        'approval_user_id' => 1,
        'is_approve' => $faker->boolean(),
        'remark' => $faker->text()
    ];
});
