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
        Schema::create('club_teacher', function (Blueprint $table) {
            $table->foreignUlid('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignUlid('club_id')->constrained('clubs')->onDelete('cascade');
            $table->primary(['teacher_id', 'club_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_teacher');
    }
};
