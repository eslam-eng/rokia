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
        Schema::create('rozmanas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('date')->index();
            $table->time('time');
            $table->foreignIdFor(\App\Models\Therapist::class,'therapist_id')->constrained('therapists')->cascadeOnDelete();
            $table->boolean('status')->default(\App\Enums\ActivationStatus::ACTIVE->value);
            $table->unique(['therapist_id','date'],'unique_therapist_rozmana');
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
        Schema::dropIfExists('rozmanas');
    }
};
