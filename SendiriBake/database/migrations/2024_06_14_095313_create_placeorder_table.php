<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeorder', function (Blueprint $table) {
            $table->integer('Id', true);
            $table->string('orderdetails');
            $table->string('totalprice');
            $table->date('pickup')->nullable();
            $table->string('status', 10);
            $table->integer('phoneNum')->nullable();
            $table->string('custName')->nullable();
            $table->binary('receipt')->nullable();
            $table->string('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placeorder');
    }
};
