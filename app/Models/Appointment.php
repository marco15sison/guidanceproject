<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'counsellor_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'cancellation_reason',
        'cancelled_at',
        'cancelled_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Status constants for appointment status
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_APPROVED = 'approved'; // Added this status
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED = 'rejected'; // Added this status
    const STATUS_RESCHEDULED = 'rescheduled';
    const STATUS_NO_SHOW = 'no_show';
    const STATUS_IN_PROGRESS = 'in_progress';

    /**
     * Get all possible status options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_APPROVED => 'Approved', // Added this status
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_REJECTED => 'Rejected', // Added this status
            self::STATUS_RESCHEDULED => 'Rescheduled',
            self::STATUS_NO_SHOW => 'No Show',
            self::STATUS_IN_PROGRESS => 'In Progress',
        ];
    }

    /**
     * Get the student associated with the appointment.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the counsellor associated with the appointment.
     */
    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class);
    }

    /**
     * Get the notes associated with the appointment.
     */
    public function notes()
    {
        return $this->hasMany(CounsellingNote::class);
    }

    /**
     * Get the feedback associated with the appointment.
     */
    public function feedback()
    {
        return $this->hasOne(AppointmentFeedback::class);
    }

    /**
     * Scope a query to only include appointments with the given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include appointments for the given student.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $studentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope a query to only include appointments for the given counsellor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $counsellorId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCounsellor($query, $counsellorId)
    {
        return $query->where('counsellor_id', $counsellorId);
    }

    /**
     * Scope a query to only include upcoming appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->whereIn('status', [
                self::STATUS_PENDING,
                self::STATUS_CONFIRMED,
                self::STATUS_APPROVED, // Added this status
                self::STATUS_RESCHEDULED
            ]);
    }

    /**
     * Scope a query to only include pending or approved appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_PENDING, 
            self::STATUS_CONFIRMED, 
            self::STATUS_APPROVED, 
            self::STATUS_RESCHEDULED,
            self::STATUS_IN_PROGRESS
        ]);
    }

    /**
     * Scope a query to only include completed appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include cancelled or rejected appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelledOrRejected($query)
    {
        return $query->whereIn('status', [self::STATUS_CANCELLED, self::STATUS_REJECTED, self::STATUS_NO_SHOW]);
    }

    /**
     * Check if the appointment is active (pending, confirmed, approved, rescheduled, or in progress).
     *
     * @return bool
     */
    public function isActive()
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_APPROVED,
            self::STATUS_RESCHEDULED,
            self::STATUS_IN_PROGRESS
        ]);
    }

    /**
     * Check if the appointment is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the appointment is cancelled, rejected, or no-show.
     *
     * @return bool
     */
    public function isCancelledOrRejected()
    {
        return in_array($this->status, [
            self::STATUS_CANCELLED,
            self::STATUS_REJECTED,
            self::STATUS_NO_SHOW
        ]);
    }

    /**
     * Get the status display name.
     *
     * @return string
     */
    public function getStatusDisplayAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get the badge color for the status.
     *
     * @return string
     */
    public function getStatusBadgeColorAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'warning';
            case self::STATUS_CONFIRMED:
            case self::STATUS_APPROVED:
                return 'success';
            case self::STATUS_COMPLETED:
                return 'info';
            case self::STATUS_CANCELLED:
                return 'danger';
            case self::STATUS_REJECTED:
            case self::STATUS_NO_SHOW:
                return 'secondary';
            case self::STATUS_RESCHEDULED:
                return 'primary';
            case self::STATUS_IN_PROGRESS:
                return 'dark';
            default:
                return 'light';
        }
    }
}