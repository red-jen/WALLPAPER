<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'artwork_id',
        'wallpaper_id',
        'quantity',
        'price',
        'options',
        'name', // Add name field if it exists in your schema
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function wallpaper()
    {
        return $this->belongsTo(Wallpaper::class);
    }

    // Accessor to get name if not directly stored
    public function getProductNameAttribute()
    {
        if ($this->artwork) {
            return $this->artwork->title ?? 'Custom Artwork';
        }

        if ($this->wallpaper) {
            return $this->wallpaper->title ?? 'Wallpaper';
        }

        return 'Product #' . $this->id;
    }
}
