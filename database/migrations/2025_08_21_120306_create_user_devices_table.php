<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            // polymorphic relation
            $table->unsignedBigInteger('deviceable_id');   
            $table->string('deviceable_type');             
            $table->string('device_token')->unique();  // FCM token
            $table->string('device_type')->nullable(); // android, ios, web
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
