<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Paper;
use App\Models\Design;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'width',
        'height',
        'image_path',
        'paper_id',
        'design_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
    ];

    /**
     * Get the user who owns the artwork.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the paper used for this artwork.
     */
    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }
    
    /**
     * Get the design used for this artwork.
     */
    public function design()
    {
        return $this->belongsTo(Design::class);
    }
    
    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}