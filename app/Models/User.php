<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function responses() : HasMany
    {
        return $this->hasMany(Response::class, 'responder_id');
    }

    public function profile() : HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $user    = Auth::user();
        $panelId = $panel->getId();

        return match ($panelId) {
            'admin' => $user && $user->hasRole('super_admin'),
            'responder'     => $user && $user->hasAnyRole(['responder']),
            default       => true, // allow 'auth' or fallback
        };
    }

    public function usersPanel(): string
    {
        $role = $this->getRoleNames()->first();

        return match ($role) {
            'super_admin' => Filament::getPanel('admin')->getUrl(),
            'responder'    => Filament::getPanel('responder')->getUrl(),
            default       => route('filament.auth.auth.login'),
        };
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     $user    = Auth::user();
    //     $panelId = $panel->getId();

    //     return match ($panelId) {
    //         'admin' => $user && $user->hasRole('super_admin'),
    //         'responder'     => $user && $user->hasAnyRole(['responder']),
    //         default       => true, // allow 'auth' or fallback
    //     };
    // }

    // public function usersPanel(): string
    // {
    //     $role = $this->getRoleNames()->first();

    //     return match ($role) {
    //         'super_admin' => Filament::getPanel('admin')->getUrl(),
    //         'responder'    => Filament::getPanel('responder')->getUrl(),
    //         default       => route('filament.auth.auth.login'),
    //     };
    // }
}
