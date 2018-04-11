<?php

use Faker\Generator as Faker;

$factory->define(DurianSoftware\Models\InquiryPurchasingOrder::class, function (Faker $faker) {
    return [
        'client_id' => $faker->randomDigitNotNull(3),
        'inquiry_id' => $faker->randomDigitNotNull(3),
        'purchasing_order_id' => $faker->randomDigitNotNull(3)
    ];
});
