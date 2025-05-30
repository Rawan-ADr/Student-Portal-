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
        Schema::create('field__validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validation_id')->constrained('validations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field__validations');
    }
};
