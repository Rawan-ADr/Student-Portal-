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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_record_id')->constrained('course_records')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('practical_mark', 5, 2)->nullable();
            $table->decimal('theoretical_mark', 5, 2)->nullable();
            $table->decimal('total_mark', 5, 2);
            $table->enum('status', ['pass', 'fail']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
