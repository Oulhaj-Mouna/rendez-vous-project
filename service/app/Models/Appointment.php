<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_id', 'prestataire_id', 'service_id',
        'appointment_date', 'status', 'notes'
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'datetime',
        ];
    }

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function prestataire()
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Scopes
    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeConfirmed($query) { return $query->where('status', 'confirmed'); }
    public function scopeToday($query)     { return $query->whereDate('appointment_date', today()); }
}