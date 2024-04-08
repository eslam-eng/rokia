<?php

namespace App\Models;

use App\Enums\BookAppointmentStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookAppointment extends Model
{
    use HasFactory,SoftDeletes,Filterable;

    protected $fillable = ['client_id', 'therapist_id', 'date', 'time', 'day_id', 'price', 'status', 'user_description', 'notify','transaction_id','payment_status'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,'client_id');
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class,'therapist_id');
    }

    protected function isAvailable(): Attribute
    {
        $appointment_date = Carbon::create("$this->date $this->time");
        $now = Carbon::now()->timezone('Asia/Riyadh')->format('Y-m-d H:i:s');
        $currentDate = Carbon::parse($now);
        return Attribute::make(
            get: fn() => $appointment_date->lte($currentDate) && $this->status == BookAppointmentStatusEnum::INPROGRESS->value && $this->payment_status == PaymentStatusEnum::PAID->value,
        );
    }

}
