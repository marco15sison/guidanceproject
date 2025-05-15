<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentNote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_id',
        'admin_id',
        'note',
        'note_type',
        'is_visible_to_student',
        'is_visible_to_counsellor', // Changed to British spelling
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible_to_student' => 'boolean',
        'is_visible_to_counsellor' => 'boolean', // Changed to British spelling
        'read_at' => 'datetime',
    ];

    /**
     * Get the appointment that owns the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the admin that created the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Scope a query to only include notes visible to students.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleToStudent($query)
    {
        return $query->where('is_visible_to_student', true);
    }

    /**
     * Scope a query to only include notes visible to counsellors.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleToCounsellor($query) // Changed to British spelling
    {
        return $query->where('is_visible_to_counsellor', true); // Changed to British spelling
    }

    /**
     * Scope a query to only include unread notes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to filter by note type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('note_type', $type);
    }

    /**
     * Mark the note as read.
     *
     * @return bool
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            return $this->update(['read_at' => now()]);
        }

        return false;
    }

    /**
     * Check if the note is read.
     *
     * @return bool
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }
}