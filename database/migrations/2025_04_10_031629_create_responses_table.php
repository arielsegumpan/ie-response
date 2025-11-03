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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents')->cascadeOnDelete();
            $table->foreignId('responder_id')->constrained('users')->cascadeOnDelete();
            $table->enum('response_type', ['fire','medical','police','other'])->default('other');
            $table->enum('status', ['assigned','en_route','on_scene','completed','cancelled'])->default('assigned');
            $table->timestamp('assignment_date')->useCurrent();
            $table->timestamp('eta')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('completion_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
