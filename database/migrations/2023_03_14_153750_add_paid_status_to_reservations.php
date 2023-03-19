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
        Schema::table('reservations', function (Blueprint $table) {
            $table->double('total')->default(0);
            $table->timestamp('ride_at')->nullable();
            $table->timestamp('drop_at')->nullable();
            $table->string('card_last_numbers')->nullable();;
            $table->enum('is_paid', [1, 2])->comment('1-Paid, 2-Not Paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
};
