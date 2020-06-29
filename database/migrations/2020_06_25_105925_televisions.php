<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Televisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->timestamps();
        });

        Schema::create('televisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->enum('region',['National','Local']);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            
        });

        Schema::create('television_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('television_id')->unsigned()->nullable();
            $table->string('program_name',100);
            $table->date('date')->nullable();
            $table->string('time_start',100);
            $table->string('time_end',100);
            $table->enum('time',['Prime','Non Prime'])->nullable();
            $table->enum('duration',['15','30','45','60'])->nullable();
            $table->enum('position',['Premium','Run On Point'])->nullable();
            $table->integer('premium_price')->default(0);
            $table->integer('run_price')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('television_id')->references('id')->on('televisions');
        });

        Schema::create('radios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('city_id')->unsigned()->nullable();
            $table->enum('region',['National','Local']);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::create('radio_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('radio_id')->unsigned()->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->enum('type',['Loose Spot','Add Lips'])->nullable();
            $table->enum('time',['Prime','Non Prime'])->nullable();
            $table->integer('price')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('radio_id')->references('id')->on('radios');
        });

        Schema::create('newspapers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            
        });

        Schema::create('newspaper_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newspaper_id')->unsigned()->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->enum('size',['Half Page','Quarter Page'])->nullable();
            $table->enum('position',['Premium','Run On Point'])->nullable();
            $table->integer('price')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('newspaper_id')->references('id')->on('newspapers');
        });

        Schema::create('out_of_homes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('city_id')->unsigned()->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::create('out_of_home_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_of_home_id')->unsigned()->nullable();
            $table->enum('type',['Static','LED'])->nullable();
            $table->enum('duration',['15','30','45','60'])->nullable();
            $table->integer('period')->default(1);
            $table->integer('price')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('out_of_home_id')->references('id')->on('out_of_homes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('out_of_home_details');
        Schema::drop('out_of_homes');
        Schema::drop('newspaper_details');
        Schema::drop('newspapers');
        Schema::drop('radio_details');
        Schema::drop('radios');
        Schema::drop('television_details');
        Schema::drop('televisions');
        Schema::drop('cities');
    }
}
