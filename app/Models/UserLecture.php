<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLecture extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','relatable_id','relatable_type'];

}
