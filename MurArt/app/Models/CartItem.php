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
        'options'
    ];
    
    protected $casts = [
        'options' => 'array',
    ];
    
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
}