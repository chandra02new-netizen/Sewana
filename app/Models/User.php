<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method bool hasRole(string|array $roles)
 * @method bool hasAnyRole(string|array $roles)
 * @method $this|mixed assignRole(...$roles)
 * @method \Illuminate\Support\Collection getRoleNames()
 * @method static \Illuminate\Database\Eloquent\Builder|User role(string|array $roles, string|null $guard = null)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Orders owned by this user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Assign the default customer role automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (! $user->hasAnyRole(['pemilik', 'pegawai', 'penyewa'])) {
                $user->assignRole('penyewa'); // Default role.
            }
        });
    }
}
