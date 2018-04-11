<?php

namespace NonEssentialPurchasingOrder;

use Illuminate\Database\Seeder;

class FactNonEssentialPurchasingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('fact_non_essential_purchasing_orders')->truncate();
        factory(\DurianSoftware\Models\FactNonEssentialPurchasingOrder::class, 100)->create();
    }
}
