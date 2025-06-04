<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Paper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'thickness',
        'size',
        'color',
        'finish',
        'usage',
        'is_active',
        'price',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'thickness' => 'integer',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get all designs that use this paper type.
     */
    public function designs(): BelongsToMany
    {
        return $this->belongsToMany(Design::class)->withTimestamps();
    }

    /**
     * Get formatted price with currency symbol.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get thickness with GSM unit.
     */
    public function getThicknessWithUnitAttribute(): string
    {
        return $this->thickness ? $this->thickness . ' GSM' : 'N/A';
    }
}