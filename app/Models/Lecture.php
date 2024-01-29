<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lecture extends Model implements HasMedia
{
    use Filterable, EscapeUnicodeJson, InteractsWithMedia;

    protected $fillable = [
        'title', 'therapist_id', 'duration', 'description', 'price', 'status', 'is_paid', 'type', 'publish_date',
    ];

    public function getImageCoverAttribute()
    {
        return $this->getMedia('*', ['type' => 'image'])->first()->getUrl();
    }

    public function getLectureContentAttribute()
    {
        return $this->getMedia('*', ['type' => 'mp3'])->first()->getUrl();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_lectures','lecture_id');
    }

    public function therapist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id')->where('type', UsersType::THERAPIST->value);
    }

    public function wishlist(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Wishlist::class, 'relatable');
    }


    public function scopeSubscribeUsers(Builder $builder)
    {
        if (!auth()->check())
            return $builder;
        $user_id = auth()->id();
        $builder->leftJoin('user_lectures', function ($join) use ($user_id) {
            $join->on('lectures.id', '=', 'user_lectures.lecture_id')
                ->where('user_lectures.user_id', '=', $user_id);
        })->addSelect(DB::raw('IF(user_lectures.user_id IS NOT NULL, 1, 0) as is_subscribed'));
    }

    public function scopeFavorites(Builder $builder)
    {
        if (!auth()->check())
            return $builder;
        $user_id = auth()->id();
        $builder->leftJoin('wishlists', function ($join) use ($user_id) {
            $join->on('lectures.id', '=', 'wishlists.relatable_id')
                ->where('wishlists.relatable_type', '=', get_class(new Lecture()))
                ->where('wishlists.user_id', '=', $user_id);
        })->addSelect(DB::raw('IF(wishlists.user_id IS NOT NULL, 1, 0) as is_favorite'));
    }
}
