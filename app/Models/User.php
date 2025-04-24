<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use database\factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Filament\Panel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $contact_notifications
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "password" => "hashed",
            "contact_notifications" => "boolean",
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, config('app.allowed_email_domain'));
    }
}
