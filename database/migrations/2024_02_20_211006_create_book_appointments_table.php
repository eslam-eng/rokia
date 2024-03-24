<?php

use App\Enums\BookAppointmentStatusEnum;
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
        Schema::create('book_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'client_id')->constrained('users');
            $table->foreignIdFor(\App\Models\Therapist::class)->constrained('therapists');
            $table->date('date');
            $table->string('time');
            $table->integer('day_id');
            $table->decimal('price');
            $table->tinyInteger('status')->default(BookAppointmentStatusEnum::PENDING->value);
            $table->string('transaction_id')->nullable();
            $table->tinyInteger('payment_status')->default(\App\Enums\PaymentStatusEnum::NOTPAID->value);
            $table->string('user_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_appointments');
    }
};
