<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Client extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',100);
            $table->string('password',255);
            $table->string('profile_picture_url',255)->nullable();
            $table->tinyInteger('isPersonal')->default(1);
            $table->tinyInteger('isVerif')->default(0);
            $table->string('name',100);
            $table->string('phone_code',100);
            $table->string('phone_number',100);
            $table->string('nationality',100);
            $table->date('date_of_birth')->nullable();
            $table->string('ktp',100);
            $table->string('npwp',100);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
