<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->nullable()->index();
            $table->string('first_name')->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->date('birthdate')->nullable()->index();
            $table->string('baseCurrency')->nullable()->index();
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
        Schema::dropIfExists('travelers');
    }
}
