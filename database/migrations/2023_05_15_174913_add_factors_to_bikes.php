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
        Schema::table('bikes', function (Blueprint $table) {
            $table->string('intensity')->default("0");
            $table->string('temperature')->default("0");
            $table->string('humidity')->default("0");
            $table->boolean('air_quality')->default(false);
            $table->boolean('rainy')->default(false);
            $table->boolean('waterlevel')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bikes', function (Blueprint $table) {
            //
        });
    }
};
