<?php

namespace NonEssentialPurchasingOrder;

use Illuminate\Database\Seeder;

class NonEssentialPurchasingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('dim_non_essential_purchasing_orders')->truncate();
        \DB::table('fact_non_essential_purchasing_orders')->truncate();
        factory(\DurianSoftware\Models\NonEssentialPurchasingOrder::class, 100)->create()->each(
            function ($NonEssentialPurchasingOrder) {
                    factory(\DurianSoftware\Models\FactNonEssentialPurchasingOrder::class, 5)->create(["purchasing_order_id" => $NonEssentialPurchasingOrder->id]);
            }
        );
    }
}
