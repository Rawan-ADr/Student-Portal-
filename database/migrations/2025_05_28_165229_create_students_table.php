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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lineage');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('registration_place_number');
            $table->string('nationality');
            $table->string('national_number',11)->unique();
            $table->string('university_number')->unique()->nullable();
            $table->string('governorate');
            $table->string('temporary_address');
            $table->string('address');
            $table->string('secondary_school');
            $table->enum('type',['scientific','vocational']);
            $table->enum('acceptance',['general','parallel']);
            $table->date('date_of_secondarySchool_cretificate');
            $table->integer('total_grades');
            $table->string('department')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
