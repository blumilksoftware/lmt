<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Models;

use Blumilksoftware\Lmt\Enums\Role;
use database\factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property Role $role
 * @property bool $contact_notifications
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read bool $isAdmin
 */
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
        "moderator",
        "active",
    ];
    protected $hidden = [
        "password",
        "remember_token",
    ];
    protected $casts = [
        "active" => "boolean",
        "email_verified_at" => "datetime",
        "password" => "hashed",
        "role" => Role::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->active && str_ends_with($this->email, config("app.allowed_email_domain"));
    }

    public function isModerator(): bool
    {
        return $this->role === Role::Moderator;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    protected function casts(): array
    {
        return [
            "password" => "hashed",
            "contact_notifications" => "boolean",
        ];
    }
}
