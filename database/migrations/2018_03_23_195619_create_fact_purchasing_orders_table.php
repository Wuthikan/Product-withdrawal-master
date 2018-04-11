<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactPurchasingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fact_purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('purchasing_order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('publisher_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('platform_id')->unsigned();
            $table->integer('edition_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('product_item_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('product_item_barcodes_id')->unsigned()->nullable();
            $table->integer('warehouse_id')->unsigned();
            $table->integer('product_type_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->decimal('price_per_unit', 15, 4);
            $table->decimal('discount_per_unit', 15, 4)->nullable();
            $table->decimal('shipping_fee_per_unit', 15, 4)->nullable();
            $table->decimal('import_duty_per_unit', 15, 4)->nullable();
            $table->decimal('amount_before_vat_per_unit', 15, 4);
            $table->decimal('vat_per_unit', 15, 4)->nullable();
            $table->decimal('amount_including_vat_per_unit', 15, 4);
            $table->decimal('sub_total_before_vat', 15, 4);
            $table->decimal('vat_sub_total', 15, 4);
            $table->decimal('sub_total_including_vat', 15, 4);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fact_purchasing_orders');
    }
}
