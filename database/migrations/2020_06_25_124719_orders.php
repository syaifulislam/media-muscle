<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->string('invoice_number',255);
            $table->float('total_price',8,2);
            $table->enum('status',['On Progress','Completed']);
            $table->integer('confirm_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('confirm_by')->references('id')->on('users');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('television_detail_id')->unsigned()->nullable();
            $table->integer('radio_detail_id')->unsigned()->nullable();
            $table->integer('newspaper_detail_id')->unsigned()->nullable();
            $table->integer('out_of_home_detail_id')->unsigned()->nullable();
            $table->string('item_name',100);
            $table->float('price',8,2);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->longtext('additional_information')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('television_detail_id')->references('id')->on('television_details');
            $table->foreign('radio_detail_id')->references('id')->on('radio_details');
            $table->foreign('newspaper_detail_id')->references('id')->on('newspaper_details');
            $table->foreign('out_of_home_detail_id')->references('id')->on('out_of_home_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_details');
        Schema::drop('orders');
    }
}
