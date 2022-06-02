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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')
                ->nullable()
                ->constrained();
            $table->string('holder_name')->nullable();
            $table->string('holder_email')->nullable();
            $table->string('holder_phone')->nullable();
            $table->integer('guest_quantity');
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('is_cancelled')->default(false);
            $table->string('details')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
