<?php

use Faker\Generator as Faker;

$factory->define(DurianSoftware\Models\Inquiry::class, function (Faker $faker) {
    return [
        'client_id' => 1,
        'date_id' => rand(1, 10),
        'inquiry_no' => rand(1, 10),
        'company_id' => rand(1, 10),
        'branch_id' => rand(1, 10),
        'billing_address' => $faker->address,
        'sub_district_id' => rand(1, 10),
        'district_id' => rand(1, 10),
        'province_id' => rand(1, 10),
        'postcode_id' => rand(10000, 60000),
        'total_quantity' => rand(20, 30),
        'total_backlog' => rand(1, 10),
        'is_approve' => $faker->randomElement([null, 'approve','unapprove']),
        // 'approval_user_id' => ,
        'remark'=> $faker->text
    ];
});
