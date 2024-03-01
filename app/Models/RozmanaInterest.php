<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RozmanaInterest extends Model
{
    use HasFactory;
    protected $fillable = ['rozmana_id','interest_id'];
}
