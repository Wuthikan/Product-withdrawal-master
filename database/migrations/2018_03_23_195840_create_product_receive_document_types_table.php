<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReceiveDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_receive_document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('company_id')->unsigned();
            $table->integer('product_receipt_id');
            $table->integer('reference_id');
            $table->string('document_type');
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
        Schema::dropIfExists('product_receive_document_types');
    }
}
