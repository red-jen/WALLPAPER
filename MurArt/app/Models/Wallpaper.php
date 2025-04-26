<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallpaper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'price',
        'width',
        'height',
        'stock',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'width' => 'integer',
        'height' => 'integer',
        'stock' => 'integer',
        'downloads' => 'integer',
    ];

    /**
     * Get the category of the wallpaper.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for this wallpaper.
     */
    public function images(): HasMany
    {
        return $this->hasMany(WallpaperImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary image for this wallpaper.
     */
    public function primaryImage()
    {
        return $this->hasOne(WallpaperImage::class)->where('is_primary', true);
    }

    /**
     * Get the primary image URL or a placeholder if none exists.
     */
    public function getImageUrlAttribute(): string
    {
        $primaryImage = $this->primaryImage;
        
        if ($primaryImage) {
            return asset('storage/' . $primaryImage->image_path);
        }
        
        // Get the first image if no primary image is set
        $firstImage = $this->images()->first();
        
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }
        
        // Return a placeholder image if no images exist
        return asset('img/placeholder.jpg');
    }

    /**
     * Get the paper types recommended for this wallpaper.
     */
    public function papers(): BelongsToMany
    {
        return $this->belongsToMany(Paper::class, 'paper_wallpaper')
                    ->withPivot('is_recommended')
                    ->withTimestamps();
    }

    /**
     * Get the reviews for this wallpaper.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get the dimensions as a formatted string.
     */
    public function getDimensionsAttribute(): string
    {
        if ($this->width && $this->height) {
            return $this->width . ' x ' . $this->height . ' px';
        }
        
        return 'Dimensions not specified';
    }

    /**
     * Get the formatted price with currency symbol.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Check if the wallpaper is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Get recommended wallpapers based on category.
     */
    public function scopeRecommended($query, $limit = 4)
    {
        return $query->where('status', 'published')
                     ->where('stock', '>', 0)
                     ->inRandomOrder()
                     ->limit($limit);
    }

    /**
     * Get featured wallpapers.
     */
    public function scopeFeatured($query)
    {
        return $query->where('status', 'featured')
                     ->where('stock', '>', 0);
    }

    /**
     * Increment download count and decrement stock.
     */
    public function purchase()
    {
        if ($this->stock > 0) {
            $this->increment('downloads');
            $this->decrement('stock');
            return true;
        }
        
        return false;
    }
}