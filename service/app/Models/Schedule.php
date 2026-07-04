<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id', 'day', 'start_time', 'end_time', 'is_available'
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function prestataire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}