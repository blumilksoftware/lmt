<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use Database\Factories\SpeakerFactory;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $video_url
 * @property string $presentation
 * @property Collection $companies
 * @property Media $photo
 * @property Media $slides
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Speaker extends Model implements HasMedia, Sortable
{
    /** @use HasFactory<SpeakerFactory> */
    use HasFactory;

    use SortableTrait;
    use InteractsWithMedia;

    protected $guarded = [];
    protected $casts = [
        "companies" => AsCollection::class,
    ];
    protected $with = ["photo", "slides"];

    public function meetup(): BelongsTo
    {
        return $this->belongsTo(Meetup::class);
    }

    public function photo(): MorphOne
    {
        return $this->media()->where("collection_name", "photo")->one();
    }

    public function slides(): MorphOne
    {
        return $this->media()->where("collection_name", "slides")->one();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("photo")->singleFile();
        $this->addMediaCollection("slides")->singleFile();
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->first_name . " " . $this->last_name,
        );
    }
}
