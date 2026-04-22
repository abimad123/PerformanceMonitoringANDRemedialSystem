<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('roll_no')->unique()->nullable(); // Making it nullable temporarily in case they are generated later, or keep optional initially
            $table->string('class')->nullable();
            $table->string('section')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone')->nullable();
            $table->string('guardian_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['class', 'section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
