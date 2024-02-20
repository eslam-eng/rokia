<?php

use App\Enums\ActivationStatus;
use App\Enums\GenderTypeEnum;
use App\Models\Location;
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
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->string('device_token')->nullable();
            $table->string('address')->nullable();
            $table->foreignIdFor(Location::class,'city_id')->nullable()->constrained('locations')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Location::class,'area_id')->nullable()->constrained('locations')->nullOnDelete()->cascadeOnUpdate();
            $table->string('gender')->default(GenderTypeEnum::MALE->value);
            $table->tinyInteger('status')->default(ActivationStatus::ACTIVE->value);
            $table->decimal('therapist_commission')->default(0);
            $table->string('locale')->default(config('app.locale'));
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('avg_therapy_duration')->default(15);
            $table->integer('therpy_price')->nullable();
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
        Schema::dropIfExists('therapists');
    }
};
