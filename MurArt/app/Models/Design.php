<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_id',
        'status', // draft, published, etc.
    ];

    /**
     * Get the designer who owns the design.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}