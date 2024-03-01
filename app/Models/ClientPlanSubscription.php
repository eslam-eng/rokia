<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPlanSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','therapist_id','therapist_plan_id','start_date','end_date','price'];
}
