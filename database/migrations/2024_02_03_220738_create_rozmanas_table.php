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
            $table->string('date');
            $table->foreignIdFor(\App\Models\User::class,'therapist_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('status')->default(\App\Enums\ActivationStatus::ACTIVE->value);
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained('categories')->nullOnDelete();
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
