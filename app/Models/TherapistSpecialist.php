<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistSpecialist extends Model
{
    use HasFactory;
    protected $fillable = ['therapist_id','category_id'];

}
