<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'content',
        'target_audience',
        'publish_date',
        'expiry_date',
        'status',
        'is_featured',
        'views'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publish_date' => 'datetime',
        'expiry_date' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the announcement.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id');
    }

    /**
     * Get the attachments for the announcement.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(AnnouncementAttachment::class);
    }

    /**
     * Update announcement status based on dates.
     *
     * @return void
     */
    public function updateStatus(): void
    {
        $now = Carbon::now();
        
        // Don't change the status if it's a draft
        if ($this->status === 'draft') {
            return;
        }
        
        // Determine the appropriate status based on dates
        if ($now->lt($this->publish_date)) {
            $this->status = 'scheduled';
        } elseif ($now->gt($this->expiry_date)) {
            $this->status = 'expired';
        } else {
            $this->status = 'active';
        }
        
        $this->save();
    }

    /**
     * Get the time remaining until announcement is published.
     */
    public function getTimeRemainingAttribute(): ?string
    {
        if ($this->status !== 'scheduled') {
            return null;
        }

        $now = Carbon::now();
        $publishDate = $this->publish_date;

        if ($now->gt($publishDate)) {
            return null;
        }

        return $now->diffForHumans($publishDate, ['parts' => 2]);
    }

    /**
     * Get the expiration time remaining for active announcements.
     */
    public function getExpirationTimeRemainingAttribute(): ?string
    {
        if ($this->status !== 'active') {
            return null;
        }

        $now = Carbon::now();
        $expiryDate = $this->expiry_date;

        if ($now->gt($expiryDate)) {
            return null;
        }

        return $now->diffForHumans($expiryDate, ['parts' => 2]);
    }

    /**
     * Get a short excerpt of the content.
     */
    public function getExcerptAttribute($length = 200): string
    {
        $text = strip_tags($this->content);
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . '...';
    }

    /**
     * Scope a query to only include active announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include scheduled announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include expired announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope a query to only include draft announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include featured announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Scope a query to only include published announcements (active and not expired).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        $now = Carbon::now();
        
        return $query->where('status', 'active')
                     ->where('publish_date', '<=', $now)
                     ->where('expiry_date', '>=', $now);
    }
    
    /**
     * Scope a query to filter by target audience.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $audience
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAudience(Builder $query, string $audience): Builder
    {
        return $query->where('target_audience', $audience);
    }
    
    /**
     * Scope a query to search announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }
    
    /**
     * Get related announcements from the same category.
     *
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedAnnouncements(int $limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where('category_id', $this->category_id)
            ->orderBy('publish_date', 'desc')
            ->limit($limit)
            ->get();
    }
}