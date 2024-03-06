<?php

use App\Models\ClientPlanSubscription;
use App\Models\TherapistPlan;
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
            $table->foreignIdFor(ClientPlanSubscription::class)
                ->nullable()
                ->constrained('client_plan_subscriptions')
                ->nullOnDelete();
            $table->string('title');
            $table->string('body');
            $table->string('date');
            $table->time('time');
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
