<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isAdmin(): bool       { return $this->role === 'admin'; }
    public function isPrestataire(): bool  { return $this->role === 'prestataire'; }
    public function isClient(): bool      { return $this->role === 'client'; }


    // Relations
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function appointmentsAsClient()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    public function appointmentsAsPrestataire()
    {
        return $this->hasMany(Appointment::class, 'prestataire_id');
    }

        public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
