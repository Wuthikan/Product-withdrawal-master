<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentConditionsCreditTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_conditions_credit_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->integer('pay_affter_recieve_day')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->decimal('pay_percent', 5, 2)->nullable();
            $table->decimal('pay_amount_before_vat', 15, 4)->nullable();
            $table->decimal('vat', 13, 4)->nullable();
            $table->decimal('pay_amount_after_vat', 15, 4)->nullable();
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
        Schema::dropIfExists('payment_conditions_credit_term');
    }
}
