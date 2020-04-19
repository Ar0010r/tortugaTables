<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id');
            $table->smallInteger('direction');
            $table->smallInteger('condition');
            $table->string('content');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('shop')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('holder')->nullable();
            $table->timestamps();

            $table->foreign('courier_id')->references('id')->on('couriers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
