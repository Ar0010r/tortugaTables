<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->smallInteger('payment_method')->default(0);
            $table->string('paypal_email')->nullable()->unique();
            $table->string('address')->unique();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->smallInteger('race')->nullable();
            $table->timestamps();

            $table->foreign('manager_id')->references('id')->on('managers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('couriers');
    }
}
