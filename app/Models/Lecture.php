<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lecture extends Model implements HasMedia
{
    use HasFactory, Filterable, EscapeUnicodeJson, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title', 'therapist_id', 'duration', 'description', 'price', 'status', 'is_paid', 'type', 'publish_date',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_lectures', 'lecture_id');
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class, 'therapist_id');
    }

    public function wishlist(): MorphMany
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
                ->where('user_lectures.user_id', '=', $user_id)
                ->where('user_lectures.payment_status', PaymentStatusEnum::PAID->value);
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

    protected function imageCoverUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => !empty($this->getFirstMediaUrl('lectures_covers')) ? $this->getFirstMediaUrl('lectures_covers') : asset('assets/img/default_lecture'),
        );
    }

    protected function lectureMediaContentUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('lectures_media_content') ?: null
        );
    }

    protected function isAvailable(): Attribute
    {
        $date = Carbon::parse($this->publish_date);
        return Attribute::make(
            get: fn() => $date->lte(Carbon::now()),
        );
    }
}
