<?php

use App\Models\Incident;
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
        Schema::create('incident_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Incident::class, 'incident_id')->constrained('incidents')->cascadeOnDelete();
            $table->decimal('latitude', 12, 9);
            $table->decimal('longitude', 12, 9);
            $table->json('geojson')->nullable();
            $table->text('location_description')->nullable();
            $table->text('landmark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_locations');
    }
};
