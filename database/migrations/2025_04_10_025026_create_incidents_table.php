<?php

use App\Models\User;
use App\Models\IncidentType;
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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'reporter_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(IncidentType::class, 'incident_type_id')->nullable()->constrained('incident_types')->cascadeOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('incident_number')->unique()->index();
            $table->json('involved')->nullable();
            $table->text('recommendations')->nullable();
            $table->longText('description');
            $table->enum('status', ['reported','verified','in_progress','resolved','closed'])->default('reported');
            $table->timestamp('verification_date')->useCurrent();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
