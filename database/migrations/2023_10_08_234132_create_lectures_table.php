<?php

use App\Enums\ActivationStatus;
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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(\App\Models\User::class,'therapist_id')->constrained('users');
            $table->string('duration')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price')->default(0);
            $table->enum('status', ActivationStatus::values());
            $table->enum('is_paid',[0,1])->default(0);
            $table->smallInteger('type');
            $table->timestamp('publish_date');
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
        Schema::dropIfExists('lectures');
    }
};
