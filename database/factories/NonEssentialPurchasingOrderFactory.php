<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(DurianSoftware\Models\NonEssentialPurchasingOrder::class, function (Faker $faker) {


    return [
        'client_id' => 1,
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
        'currency_id' => 1,
        'total_quantity' => rand(0, 50),
        'backlog_quatity' => rand(0, 50),
        'amount' => rand(0, 50),
        'discount' => rand(0, 50),
        'amount_before_vat' => rand(0, 50),
        'vat' => rand(0, 50),
        'grand_total' => rand(0, 50),
        'approval_user_id' => 1,
        'is_approve' => 'approve',
        'remark' => $faker->sentence
    ];
});
