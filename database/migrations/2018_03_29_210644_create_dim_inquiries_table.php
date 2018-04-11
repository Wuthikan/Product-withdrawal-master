<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dim_inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default("1");
            $table->integer('date_id')->unsigned();
            $table->string('inquiry_no')->nullable();
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->text('billing_address');
            $table->integer('sub_district_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->integer('province_id')->unsigned();
            $table->integer('postcode_id')->unsigned();
            $table->integer('total_quantity');
            $table->integer('total_backlog');
            $table->enum('is_approve', ['approve','unapprove'])->nullable()->default(null);
            ;
            $table->integer('approval_user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('dim_inquiries');
    }
}
