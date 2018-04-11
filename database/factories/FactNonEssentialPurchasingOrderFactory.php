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

$factory->define(DurianSoftware\Models\FactNonEssentialPurchasingOrder::class, function (Faker $faker) {


    return [
        'client_id' => 1,
        'purchasing_order_id' => 1,
        'product_id' => 1,
        'publisher_id' => 1,
        'category_id' => 1,
        'platform_id' => 1,
        'edition_id' => 1,
        'region_id' => 1,
        'product_item_id' => 1,
        'unit_id' => 1,
        'product_item_barcodes_id' => 1,
        'warehouse_id' => 1,
        'quantity' => rand(0, 50),
        'currency_id' => 1,
        'price_per_unit' => rand(0, 50),
        'discount_per_unit' => rand(0, 50),
        'amount_before_vat_per_unit' => rand(0, 50),
        'vat_per_unit' => rand(0, 50),
        'amount_including_vat_per_unit' => rand(0, 50),
        'sub_total_before_vat' => rand(0, 50),
        'vat_sub_total' => rand(0, 50),
        'sub_total_including_vat' => rand(0, 50)
    ];
});
