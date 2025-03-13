<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use Database\Factories\MeetupFactory;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $place
 * @property string $localization
 * @property string $fb_event
 * @property string $photographers
 * @property bool $active
 * @property Carbon $date
 * @property Collection<Agenda> $agendas
 * @property Collection<Speaker> $speakers
 * @property Collection<Company> $companies
 * @property Collection<Media> $photos
 * @property Media $regulations
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Meetup extends Model implements HasMedia
{
    /** @use HasFactory<MeetupFactory> */
    use HasFactory;

    use InteractsWithMedia;

    protected $guarded = [];
    protected $casts = [
        "date" => "datetime",
    ];

    public function isCurrent(): bool
    {
        return $this->date->gte(now());
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class)->orderBy("order_column");
    }

    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class)->orderBy("order_column");
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class)->orderBy("order_column");
    }

    public function regulations(): MorphOne
    {
        return $this->media()->where("collection_name", "regulations")->one();
    }

    public function photos(): MorphMany
    {
        return $this->media()->where("collection_name", "photos")->orderBy("order_column");
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("active", true);
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->whereDate("date", ">=", now());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("regulations")->singleFile();
        $this->addMediaCollection("photos");
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion("webp")
            ->format("webp")
            ->optimize();
    }
}
