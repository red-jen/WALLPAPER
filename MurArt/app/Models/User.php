<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
        'bio',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's status badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        $statusClasses = [
            'active' => 'bg-green-100 text-green-800',
            'pending' => 'bg-amber-100 text-amber-800',
            'banned' => 'bg-red-100 text-red-800',
        ];

        $class = $statusClasses[$this->status] ?? 'bg-gray-100 text-gray-800';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $class . '">'
            . ucfirst($this->status) .
            '</span>';
    }

    /**
     * Check if the user is an admin.
     */

    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a designer.
     */
    public function isDesigner(): bool
    {
        return $this->role === 'designer';
    }

    /**
     * Check if the user is a client.
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Get the designs for the user.
     */
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    /**
     * Get the artworks created by the user.
     */
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
