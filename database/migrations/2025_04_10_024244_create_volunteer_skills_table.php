<?php

use App\Models\Skill;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('volunteer_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Volunteer::class, 'volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignIdFor(Skill::class, 'skill_id')->constrained('skills')->cascadeOnDelete();
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('beginner');
            $table->date('certification_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_skills');
    }
};
