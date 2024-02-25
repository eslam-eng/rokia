<?php

use App\Models\Invoice;
use App\Models\Lecture;
use App\Models\User;
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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Invoice::class)->constrained('invoices');
            $table->morphs('relatable');
            $table->decimal('price');
            $table->decimal('discount')->default(0);
            $table->decimal('therapist_commission');
            $table->foreignIdFor(\App\Models\User::class,'client_id')->constrained('users');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
};
