<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
        'date',
        'description',
        'title',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the bookings for this event.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the user who created the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter events by upcoming dates.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date', '>=', now())
            ->orderBy('date', 'asc');
    }

    /**
     * Scope to filter events by past dates.
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('date', '<', now())
            ->orderBy('date', 'desc');
    }

    /**
     * Get the number of available seats for this event.
     */
    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->capacity - $this->bookings()->count());
    }

    /**
     * Check if event is fully booked.
     */
    public function isFullyBooked(): bool
    {
        return $this->bookings()->count() >= $this->capacity;
    }

    /**
     * Check if event is past.
     */
    public function isPast(): bool
    {
        return $this->date->isPast();
    }
}
