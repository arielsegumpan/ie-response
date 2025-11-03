<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->foreignId('region_id')->nullable()->constrained('philippine_regions')->nullOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('philippine_provinces')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('philippine_cities')->nullOnDelete();
            $table->foreignId('barangay_id')->nullable()->constrained('philippine_barangays')->nullOnDelete();
            $table->string('street')->nullable();
            $table->string('full_address')->nullable();
            $table->json('additional_info')->nullable();
            if (DB::getDriverName() === 'pgsql') {
                $table->string('full_name')->storedAs("first_name || ' ' || last_name")->nullable();
            } elseif (DB::getDriverName() === 'sqlite') {
                $table->string('full_name')->virtualAs("first_name || ' ' || last_name")->nullable();
            } else {
                $table->string('full_name')->virtualAs("CONCAT(first_name, ' ', last_name)")->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
