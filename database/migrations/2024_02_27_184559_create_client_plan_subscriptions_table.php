<?php

use App\Models\Therapist;
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
        Schema::create('client_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TherapistPlan::class)->constrained('therapist_plans');
            $table->foreignIdFor(Therapist::class)->constrained('therapists');
            $table->foreignIdFor(User::class,'client_id')->constrained('users');
            $table->integer('rozmana_number');
            $table->integer('price');
            $table->tinyInteger('status')->default(\App\Enums\ClientPlanStatusEnum::PENDING->value);
            $table->tinyInteger('payment_status')->default(\App\Enums\PaymentStatusEnum::NOTPAID->value);
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_plan_subscriptions');
    }
};
