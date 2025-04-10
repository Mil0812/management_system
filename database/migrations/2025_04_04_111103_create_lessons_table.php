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
        Schema::create('lessons', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('teacher_id')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('student_count')->default(0);
            $table->foreignUlid('club_id')->constrained('clubs')->onDelete('cascade');
            $table->date('lesson_date');
            $table->time('lesson_time');
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->decimal('total_profit', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
