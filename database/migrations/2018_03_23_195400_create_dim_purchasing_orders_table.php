<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimPurchasingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dim_purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->text('billing_address');
            $table->integer('sub_district_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->integer('province_id')->unsigned();
            $table->integer('postcode_id')->unsigned();
            $table->integer('payment_conditions_credit_term_id')->unsigned();
            $table->integer('document_date_id')->unsigned();
            $table->integer('due_date_id')->unsigned();
            $table->integer('shipping_date_id')->unsigned();
            $table->integer('total_quantity')->unsigned();
            $table->integer('backlog_quantity')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->decimal('amount', 15, 4);
            $table->decimal('discount', 15, 4);
            $table->decimal('amount_before_vat', 15, 4);
            $table->decimal('vat', 13, 4);
            $table->decimal('grand_total', 15, 4);
            $table->integer('approval_user_id')->unsigned()->nullable();
            $table->boolean('is_approve')->nullable();
            $table->text('remark');
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
        Schema::dropIfExists('dim_purchasing_orders');
    }
}
