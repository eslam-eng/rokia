<?php

use App\Models\Therapist;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * this plans for rozmana subscribtions
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('therapist_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignIdFor(Therapist::class)->constrained('therapists')->cascadeOnDelete();
            $table->decimal('price');
            $table->integer('roznama_number')->comment('roznama number that will send to client');
            $table->boolean('status')->default(\App\Enums\ActivationStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapist_plans');
    }
};
