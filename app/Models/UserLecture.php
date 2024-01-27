<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLecture extends Model
{

    //this for paid lectures when user buy paid lecture store it here
    use HasFactory;
    protected $fillable = ['user_id','lecture_id'];

}
