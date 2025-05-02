<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Design extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image_path',
        'designer_id',
        'category_id',
    ];

    /**
     * Get the designer that owns the design.
     */
    public function designer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    /**
     * Get the category of the design.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the reviews for this design.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get paper types recommended for this design.
     */
    public function papers(): BelongsToMany
    {
        return $this->belongsToMany(Paper::class, 'design_paper')->withTimestamps();
    }

    /**
     * Get the categories for this design.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'design_category', 'design_id', 'category_id');
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Get the count of artworks using this design.
     */
    public function getArtworkUsageCountAttribute(): int
    {
        return Artwork::where('design_id', $this->id)->count();
    }
}
