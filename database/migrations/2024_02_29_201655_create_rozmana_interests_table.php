<?php

use App\Models\Interest;
use App\Models\Rozmana;
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
        Schema::create('rozmana_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rozmana::class)->constrained('rozmanas')->cascadeOnDelete();
            $table->foreignIdFor(Interest::class)->nullable()->constrained('interests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rozmana_interests');
    }
};
