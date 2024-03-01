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
        Schema::create('therapist_specialists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Therapist::class)->constrained('therapists')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Specialist::class)->constrained('specialists')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_specialists');
    }
};
