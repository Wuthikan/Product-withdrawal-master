<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiryPurchasingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_purchasing_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('inquiry_id')->unsigned();
            $table->integer('purchasing_order_id')->unsigned();
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
        Schema::dropIfExists('inquiry_purchasing_orders');
    }
}
