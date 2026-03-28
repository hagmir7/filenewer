<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // Social Login
        'provider_id',
        'provider',

        // User Metadata
        'join_date',
        'last_login',
        'phone_number',
        'status',
        'role_name',
        'avatar',
        'position',
        'department',
        'line_manager',
        'seconde_line_manager',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if (!app()->environment('production')) {
            return true; // allow access in local/dev
        }

        return (
            (str_ends_with($this->email, '@filenewer.com') && $this->hasVerifiedEmail())
            || $this->email === 'hagmir6@gmail.com'
        );
    }
}
