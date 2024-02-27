<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLecture extends Model
{

    //this for paid lectures when user buy paid lecture store it here

    use HasFactory;
    protected $fillable = ['client_id','lecture_id'];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

}
