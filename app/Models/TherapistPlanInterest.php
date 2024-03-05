<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistPlanInterest extends Model
{
    use HasFactory;

    protected $fillable = ['therapist_plan_id','interest_id'];
}
