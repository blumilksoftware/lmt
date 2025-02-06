<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use Blumilksoftware\Lmt\Enums\CompanyType;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $name
 * @property CompanyType $type
 * @property string $url
 * @property Media $logo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Company extends Model implements HasMedia, Sortable
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use SortableTrait;

    protected $guarded = [];
    protected $casts = [
        "type" => CompanyType::class,
    ];
    protected $with = ["logo"];

    public function meetup(): BelongsTo
    {
        return $this->belongsTo(Meetup::class);
    }

    public function logo(): MorphOne
    {
        return $this->media()->where("collection_name", "logo")->one();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("logo")->singleFile();
    }
}
