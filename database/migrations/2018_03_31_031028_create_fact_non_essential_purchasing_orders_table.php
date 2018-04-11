<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactNonEssentialPurchasingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fact_non_essential_purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->comment('บันทึกรหัสของบริษัท');
            $table->unsignedInteger('purchasing_order_id')->comment('ระบุรหัสเลขที่เอกสารใบสั่งซื้อ Purchasing order');
            $table->unsignedInteger('product_id')->comment('ระบุสินค้าที่ Order');
            $table->unsignedInteger('publisher_id')->comment('ระบุเลขที่ publisher');
            $table->unsignedInteger('category_id')->comment('ระบุเลขที่ category');
            $table->unsignedInteger('platform_id')->comment('ระบุเลขที่ platform');
            $table->unsignedInteger('edition_id')->comment('ระบุเลขที่ edition');
            $table->unsignedInteger('region_id')->comment('ระบุเลขที่ region');
            $table->unsignedInteger('product_item_id')->comment('ระบุเลขที่ product item');
            $table->unsignedInteger('unit_id')->comment('ระบุหน่วยของสินค้าที่ Order');
            $table->unsignedInteger('product_item_barcodes_id')->comment('ระบุเลขที่ product barcode');
            $table->unsignedInteger('warehouse_id')->comment('ระบุคลังสินค้า');
            $table->unsignedInteger('quantity')->comment('จำนวนสินค้า');
            $table->unsignedInteger('currency_id')->comment('ระบุ ค่าเงิน');
            $table->decimal('price_per_unit', 15, 4)->comment('ราคาต่อหน่วย');
            $table->decimal('discount_per_unit', 15, 4)->comment('ราคาส่วนลด');
            $table->decimal('amount_before_vat_per_unit', 15, 4)->comment('ราคาก่อนภาษี');
            $table->decimal('vat_per_unit', 13, 4)->comment('ราคาภาษี');
            $table->decimal('amount_including_vat_per_unit', 15, 4)->comment('ราคารวมภาษี');
            $table->decimal('sub_total_before_vat', 15, 4)->comment('ราคาก่อนรวมภาษีของสินค้า');
            $table->decimal('vat_sub_total', 15, 4)->comment('ราคาภาษีของสินค้า');
            $table->decimal('sub_total_including_vat', 15, 4)->comment('ราคารวมภาษีสุทธิของสินค้า');
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
        Schema::dropIfExists('fact_non_essential_purchasing_orders');
    }
}
