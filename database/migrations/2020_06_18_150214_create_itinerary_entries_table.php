<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItineraryEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_id')->nullable();
            $table->bigInteger('origin_id')->nullable();
            $table->bigInteger('destination_id')->nullable();
            $table->bigInteger('transportation_id')->nullable();
            $table->bigInteger('sub_category_id')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->double('activity_cost')->nullable();
            $table->double('transportation_cost')->nullable();
            $table->double('distance')->nullable();
            $table->integer('days')->nullable();
            $table->integer('nights')->nullable();
            $table->boolean('is_checked_in')->nullable();
            $table->string('title')->nullable();
            $table->string('tag')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itinerary_entries');
    }
}
