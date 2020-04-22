<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('qtd_per_day');
            $table->integer('qtd_movement');
            $table->string('days_week');
            $table->timestamp('dt_start');
            $table->timestamp('dt_end');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('therapist_id')->unsigned();
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('users');
            $table->integer('typetrain_id')->unsigned();
            $table->foreign('typetrain_id')->references('id')->on('type_train');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('train');
    }
}
