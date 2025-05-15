<?php
// 1. Counsellor Model (app/Models/Counsellor.php)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counsellor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'expertise1',
        'expertise2',
        'expertise3',
        'biography',
        'education',
        'specializations',
        'available_days',
        'available_hours',
        'profile_photo',
        'is_active',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the appointments associated with the counsellor.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    /**
     * Get the user associated with the counsellor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active counsellors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include NOIME CARLOS as counsellor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoimeCarlos($query)
    {
        return $query->where('name', 'NOIME CARLOS');
    }

    /**
     * Check if the counsellor is available on the given day.
     *
     * @param  string  $day
     * @return bool
     */
    public function isAvailableOn($day)
    {
        if (empty($this->available_days)) {
            return false;
        }
        
        $availableDays = explode(',', strtolower($this->available_days));
        
        return in_array(strtolower($day), $availableDays);
    }
}
