<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use Database\Factories\AgendaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $speaker
 * @property string $start
 * @property Meetup $meetup
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Agenda extends Model implements Sortable
{
    /** @use HasFactory<AgendaFactory> */
    use HasFactory;

    use SortableTrait;

    protected $guarded = [];

    public function meetup(): BelongsTo
    {
        return $this->belongsTo(Meetup::class);
    }
}
