<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPlanSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','therapist_id','therapist_plan_id','rozmana_number','price','status','payment_status','transaction_id'];

    public function therapistPlan(): BelongsTo
    {
        return $this->belongsTo(TherapistPlan::class,'therapist_plan_id');
    }

}
