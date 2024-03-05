<?php

use App\Models\Interest;
use App\Models\TherapistPlan;
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
        Schema::create('therapist_plan_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TherapistPlan::class)->constrained('therapist_plans')->cascadeOnDelete();
            $table->foreignIdFor(Interest::class)->constrained('interests')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_plan_interests');
    }
};
