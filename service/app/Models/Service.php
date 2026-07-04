<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description',
        'price', 'duration', 'category', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price'     => 'decimal:2',
        ];
    }

    // Relations
    public function prestataire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}