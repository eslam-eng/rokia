<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLecture extends Model
{

    //this for paid lectures when user buy paid lecture store it here

    use HasFactory;

    protected $fillable = [
        'lecture_id',
        'lecture_data',
        'user_id',
        'payment_status',
        'transaction_id'
    ];

    protected $casts = [
        'lecture_date'=>'json'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

}
