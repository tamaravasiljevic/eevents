<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityTable extends Migration
{
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('method');
            $table->string('ip_address');
            $table->string('action');
            $table->string('user_agent')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('model_type')->nullable();
            $table->integer('model_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('log_activities');
    }
}
