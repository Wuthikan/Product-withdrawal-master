<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_inquiry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default("1");
            $table->integer('inquiry_id')->unsigned();
            $table->integer('date_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('action', ['create', 'edit', 'soft delete', 'force delete', 'export excel' ,
                'view', 'search', 'print', 'sent email', 'undo', 'restore'])->nullable()->default(null);
            $table->text('field_name')->nullable();
            $table->text('value_before')->nullable();
            $table->text('value_after');
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
        Schema::dropIfExists('log_inquiry');
    }
}
