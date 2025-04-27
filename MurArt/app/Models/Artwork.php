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
        'preview_status',
        'preview_image_path',
        'preview_updated_at',
        'status_notes',
        'production_images',
        'production_status',
        'production_notes',
        'tracking_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'preview_updated_at' => 'datetime',
        'production_images' => 'array',
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

    // Add these methods to your Artwork class
/**
 * Calculate the price of the artwork.
 * 
 * @return float
 */
public function calculatePrice()
{
    // Base price
    $basePrice = 50.00;
    
    // Add cost based on dimensions (example calculation)
    $sizePrice = ($this->width * $this->height) / 100 * 0.5;
    
    // Add cost based on paper type
    $paperPrice = $this->paper && $this->paper->price ? $this->paper->price : 10.00;
    
    // Processing fee
    $processingFee = 5.00;
    
    // Shipping estimate
    $shippingFee = 15.00;
    
    return $basePrice + $sizePrice + $paperPrice + $processingFee + $shippingFee;
}

/**
 * Get the image URL for display.
 * 
 * @return string
 */
public function getImageUrl()
{
    if ($this->preview_image_path) {
        return url('storage/' . $this->preview_image_path);
    }
    
    return url('storage/' . $this->image_path);
}
}