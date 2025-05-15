<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AnnouncementAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'announcement_id',
        'filename',
        'original_filename',
        'file_type',
        'file_size'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'url',
        'formatted_size',
        'icon_class'
    ];

    /**
     * Get the announcement that owns the attachment.
     */
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }
    
    /**
     * Get the storage path for the attachment.
     *
     * @return string
     */
    public function getPathAttribute(): string
    {
        return storage_path('app/' . $this->filename);
    }
    
    /**
     * Get the public URL for the attachment.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->filename);
    }
    
    /**
     * Format the file size for display.
     *
     * @return string
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = intval($this->file_size);
        
        if ($bytes <= 0) {
            return '0 Bytes';
        }
        
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }
    
    /**
     * Get the appropriate FontAwesome icon class based on file type.
     *
     * @return string
     */
    public function getIconClassAttribute(): string
    {
        $fileType = strtolower($this->file_type);
        
        if (str_contains($fileType, 'pdf')) {
            return 'fa-file-pdf text-danger';
        } elseif (str_contains($fileType, 'image') || str_contains($fileType, 'jpg') || str_contains($fileType, 'png') || str_contains($fileType, 'gif')) {
            return 'fa-file-image text-primary';
        } elseif (str_contains($fileType, 'word') || str_contains($fileType, 'document') || str_contains($fileType, 'docx')) {
            return 'fa-file-word text-primary';
        } elseif (str_contains($fileType, 'excel') || str_contains($fileType, 'spreadsheet') || str_contains($fileType, 'xlsx')) {
            return 'fa-file-excel text-success';
        } elseif (str_contains($fileType, 'powerpoint') || str_contains($fileType, 'presentation') || str_contains($fileType, 'pptx')) {
            return 'fa-file-powerpoint text-warning';
        } elseif (str_contains($fileType, 'zip') || str_contains($fileType, 'archive') || str_contains($fileType, 'compressed')) {
            return 'fa-file-archive text-secondary';
        } elseif (str_contains($fileType, 'audio') || str_contains($fileType, 'mp3') || str_contains($fileType, 'wav')) {
            return 'fa-file-audio text-info';
        } elseif (str_contains($fileType, 'video') || str_contains($fileType, 'mp4')) {
            return 'fa-file-video text-info';
        } elseif (str_contains($fileType, 'text') || str_contains($fileType, 'txt')) {
            return 'fa-file-alt text-secondary';
        } elseif (str_contains($fileType, 'code') || str_contains($fileType, 'json') || str_contains($fileType, 'xml')) {
            return 'fa-file-code text-dark';
        }
        
        return 'fa-file text-secondary';
    }
    
    /**
     * Determine if the file is an image.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return str_contains(strtolower($this->file_type), 'image');
    }
    
    /**
     * Determine if the file is a document (PDF, Word, etc.).
     *
     * @return bool
     */
    public function isDocument(): bool
    {
        $fileType = strtolower($this->file_type);
        return str_contains($fileType, 'pdf') || 
               str_contains($fileType, 'word') || 
               str_contains($fileType, 'document') ||
               str_contains($fileType, 'text');
    }
    
    /**
     * Delete the file from storage when the model is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($attachment) {
            Storage::delete($attachment->filename);
        });
    }
}