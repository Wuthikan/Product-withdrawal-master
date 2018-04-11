<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimNonEssentialPurchasingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dim_non_essential_purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->comment('บันทึกรหัสของบริษัท');
            $table->unsignedInteger('company_id')->comment('ระบุ Supplier  หรือ Customer');
            $table->unsignedInteger('branch_id')->comment('ระบุ branch');
            $table->text('billing_address')->comment('ระบุที่อยู่ในการจัดส่งสินค้าของสาขา');
            $table->unsignedInteger('sub_district_id')->comment('ตำบล / แขวง');
            $table->unsignedInteger('district_id')->comment('อำเภอ / เขต');
            $table->unsignedInteger('province_id')->comment('จังหวัด');
            $table->unsignedInteger('postcode_id')->comment('รหัสไปรษณีย์');
            $table->unsignedInteger('payment_conditions_credit_term_id')->comment('รหัสของ payment_condition_credit_trem');
            $table->unsignedInteger('document_date_id')->comment('วันที่เปิด PO');
            $table->unsignedInteger('due_date_id')->comment('วันที่ชำระเงิน');
            $table->unsignedInteger('shipping_date_id')->comment('วันที่ส่งของ');
            $table->unsignedInteger('total_quantity')->comment('รวมจำนวนสินค้าที่สั่งซื้อ');
            $table->unsignedInteger('backlog_quatity')->comment('จำนวนสินค้าที่ค้างรับ');
            $table->unsignedInteger('currency_id')->comment('ระบุ ค่าเงิน');
            $table->decimal('amount', 15, 4)->comment('ราคารวมสินค้า');
            $table->decimal('discount', 15, 4)->comment('ราคาส่วนลด');
            $table->decimal('amount_before_vat', 15, 4)->comment('ราคาก่อนภาษี');
            $table->decimal('vat', 13, 4)->comment('ราคาภาษี');
            $table->decimal('grand_total', 15, 4)->comment('ราคารวมสินค้า');
            $table->unsignedInteger('approval_user_id')->comment('บันทึกว่าใคร (user_id) เป็นคน approve purchasing order ใบนี้)');
            $table->enum('is_approve', ['approve','unapprove','Null'])->default('Null')->comment('สถานะ default (Null)');
            $table->text('remark')->comment('หมายเหตุ');
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
        Schema::dropIfExists('dim_non_essential_purchasing_orders');
    }
}
