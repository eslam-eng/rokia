<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class,'therapist_id')->constrained('users');
            $table->decimal('sub_total')->default(0);
            $table->decimal('therapist_commission');
            $table->decimal('grand_total');
            $table->tinyInteger('status')->default(\App\Enums\ActivationStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
