<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtworkPreview extends Model
{
    use HasFactory;

    protected $fillable = [
        'artwork_id',
        'status',
        'image_path',
        'admin_notes',
        'client_feedback',
        'approved_at',
        'rejected_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the artwork that owns this preview.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    /**
     * Determine if the preview is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Determine if the preview is uploaded.
     */
    public function isUploaded()
    {
        return $this->status === 'uploaded';
    }

    /**
     * Determine if the preview is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Determine if the preview is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
