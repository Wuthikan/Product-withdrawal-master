<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('dim_editions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->longText('image')->nullable();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dim_editions');
    }

    function seed()
    {
        \DB::table('dim_editions')->insert([
            ['name' => 'Standard'],
            ['name' => 'Delux'],
            ['name' => 'Collecter']
        ]);
    }
}
