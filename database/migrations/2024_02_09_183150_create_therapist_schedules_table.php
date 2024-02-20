<?php

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
        Schema::create('therapist_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Therapist::class)->constrained('therapists')->cascadeOnDelete();
            $table->integer('day_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->unique(['day_id','start_time','end_time','therapist_id'],'unique_day_time_for_therapist');
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
