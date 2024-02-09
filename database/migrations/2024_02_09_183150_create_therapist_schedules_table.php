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
        Schema::create('therapist_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Therapist::class)->constrained('therapists')->cascadeOnDelete();
            $table->integer('day_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('avg_therapy_duration')
                ->default(15)
                ->comment('avg duration for therapy session in minutes');
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
        Schema::dropIfExists('therapist_schedules');
    }
};
