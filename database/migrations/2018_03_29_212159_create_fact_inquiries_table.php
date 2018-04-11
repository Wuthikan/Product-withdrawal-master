<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fact_inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default("1");
            $table->integer('date_id')->unsigned();
            // $table->foreign('inquiry_id')->references('id')->on('dim_inquiries')->onDelete('cascade');
            $table->integer('inquiry_id')->unsigned();
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
            $table->decimal('unit_price');
            $table->decimal('amount');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('fact_inquiries');
    }
}
