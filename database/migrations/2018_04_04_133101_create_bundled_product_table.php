<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundledProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dim_bundled_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->string('bundled_name', 255);
            $table->decimal('promotion_srp', 15, 4)->unsigned();
            $table->integer('start_date_id')->unsigned();
            $table->integer('end_date_id')->unsigned();
            $table->boolean('is_approve')->nullable();
            $table->integer('approval_user_id')->unsigned()->nullable();
            $table->longText('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();

            /** Migrate Realtion Bundled Table
            */
            $this->bundledItems();
            $this->bundledCustomerTierPrices();
            $this->logBundledProducts();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dim_bundled_product');
    }

    /**
     * Run the migrations.
     */
    public function bundledItems()
    {
        Schema::dropIfExists('bundled_items');
        Schema::create('bundled_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('bundled_product_id')->unsigned();
            $table->integer('product_item_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('product_srp')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('platfrom_id')->unsigned();
            $table->integer('edition_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Run the migrations.
     */
    public function bundledCustomerTierPrices()
    {
        Schema::dropIfExists('bundled_customer_tier_prices');
        Schema::create('bundled_customer_tier_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default(1);
            $table->integer('bundled_product_id')->unsigned();
            $table->integer('customer_tier_id')->unsigned();
            $table->integer('price')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Run the migrations.
     */
    public function logBundledProducts()
    {
        Schema::dropIfExists('log_bundled_products');
        Schema::create('log_bundled_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->default("1");
            $table->integer('bundled_product_id')->unsigned();
            $table->integer('date_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('action', [
                'create',
                'edit',
                'soft delete',
                'force delete',
                'export excel',
                'view',
                'search',
                'print',
                'sent email',
                'undo',
                'restore'
            ])->nullable()->default(null);
            $table->text('field_name')->nullable();
            $table->text('value_before')->nullable();
            $table->text('value_after');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
