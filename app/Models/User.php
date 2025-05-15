<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_address', // Added email_address field
        'password',
        'user_type',
        'is_active',
        'email_verified_at',
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
            'is_active' => 'boolean',
        ];
    }
    
    /**
     * Check if user is admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }
    
    /**
     * Check if user is faculty
     * 
     * @return bool
     */
    public function isFaculty(): bool
    {
        return $this->user_type === 'faculty';
    }
    
    /**
     * Check if user is student
     * 
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->user_type === 'student';
    }
    
    /**
     * Get user's formatted ID (from email field)
     * 
     * @return string
     */
    public function getUserId(): string
    {
        return $this->email;
    }
    
    /**
     * Get user's email address (actual email, not ID)
     * 
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }
    
    /**
     * Set user's email address
     * 
     * @param string|null $email
     * @return void
     */
    public function setEmailAddress(?string $email): void
    {
        $this->email_address = $email;
        $this->save();
    }
    
    /**
     * Scope a query to only include active users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include faculty users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFaculty($query)
    {
        return $query->where('user_type', 'faculty');
    }
    
    /**
     * Scope a query to only include student users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStudents($query)
    {
        return $query->where('user_type', 'student');
    }
    
    /**
     * Scope a query to only include admin users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }
    
    /**
     * Validate if a faculty ID format is correct
     *
     * @param string $id
     * @return bool
     */
    public static function isValidFacultyId(string $id): bool
    {
        return preg_match('/^FAC-[A-Z]{2}$/', $id);
    }
    
    /**
     * Validate if a student ID format is correct
     *
     * @param string $id
     * @return bool
     */
    public static function isValidStudentId(string $id): bool
    {
        return preg_match('/^\d{2}-[A-Z]{2}-\d{4}$/', $id);
    }
    
    /**
     * Get user type display name
     *
     * @return string
     */
    public function getUserTypeDisplay(): string
    {
        return ucfirst($this->user_type);
    }
    
    /**
     * Check if user account is active
     * 
     * @return bool
     */
    public function isActiveAccount(): bool
    {
        return $this->is_active === true;
    }
    
    /**
     * Get users by type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUsersByType(string $type)
    {
        Log::info("Fetching users of type: $type");
        return self::where('user_type', $type)
            ->orderBy('name')
            ->get();
    }
    
    /**
     * Get all non-admin users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNonAdminUsers()
    {
        return self::where('user_type', '!=', 'admin')
            ->orderBy('user_type')
            ->orderBy('name')
            ->get();
    }
    
    /**
     * Get fully qualified email for notifications
     * Uses email_address if available, otherwise falls back to email field
     * 
     * @return string
     */
    public function routeNotificationForMail(): string
    {
        return $this->email_address ?? $this->email;
    }
    
    /**
     * Check if user has a valid email address for notifications
     * 
     * @return bool
     */
    public function hasValidEmailAddress(): bool
    {
        return !empty($this->email_address) && filter_var($this->email_address, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Override the boot method to add a logging event for user creation
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($user) {
            Log::info("New user created: {$user->name} ({$user->email}) as {$user->user_type}");
        });
        
        static::updated(function ($user) {
            Log::info("User updated: {$user->name} ({$user->email})");
        });
        
        static::deleted(function ($user) {
            Log::info("User deleted: {$user->name} ({$user->email})");
        });
    }
}