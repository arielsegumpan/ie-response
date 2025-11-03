<?php

use App\Models\OrganizationType;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('org_name');
            $table->foreignIdFor(OrganizationType::class, 'organization_type_id')->constrained('organization_types')->cascadeOnDelete();
            $table->string('org_email')->unique()->nullable();
            $table->string('org_contact_person')->nullable();
            $table->string('org_contact_phone')->nullable();
            $table->string('org_contact_email')->nullable();
            $table->string('org_img')->nullable();
            $table->text('org_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
