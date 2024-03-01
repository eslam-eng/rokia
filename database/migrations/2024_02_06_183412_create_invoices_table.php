<?php

use App\Enums\InvoiceStatusEnum;
use App\Models\Therapist;
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
            $table->foreignIdFor(Therapist::class)->constrained('therapists');
            $table->decimal('sub_total');
            $table->decimal('grand_total');
            $table->decimal('therapist_due');
            $table->tinyInteger('status')->default(InvoiceStatusEnum::PENDING->value);
            $table->date('compeleted_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
