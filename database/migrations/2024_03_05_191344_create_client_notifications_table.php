<?php

use App\Models\User;
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
        Schema::create('client_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\TherapistPlan::class)
                ->nullable()
                ->constrained('therapist_plans')
                ->nullOnDelete();
            $table->string('title');
            $table->string('body');
            $table->string('date');
            $table->time('time');
            $table->boolean('status')->default(0)->comment('0 refer that notification not send 1 send done');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_notifications');
    }
};
