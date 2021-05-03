<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->unsignedBigInteger('venue_id');
            $table->foreign('venue_id')->references('id')->on('venues')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('currency', 3);
            $table->integer('visibility');
            $table->integer('status');
            $table->unsignedInteger('total_capacity');

            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->foreign('event_type_id')->references('id')->on('event_types');

            $table->boolean('sold_out')->default(false);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->dateTime('sale_end_date_time')->nullable();
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
        Schema::dropIfExists('events');
    }
}
