<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
  
     protected $fillable = ['name', 'slug', 'description'];

     /**
      * Get the wallpapers for this category.
      */
     public function wallpapers()
     {
         return $this->hasMany(Wallpaper::class);
     }
    /**
     * Get all designs belonging to this category.
     */
    public function designs(): BelongsToMany
    {
        return $this->belongsToMany(Design::class)->withTimestamps();
    }

    /**
     * Get all categories for dropdown.
     */
    public static function getForDropdown($prepend = null)
    {
        $categories = self::orderBy('name')->get();
        
        $list = [];
        if ($prepend) {
            $list[''] = $prepend;
        }
        
        foreach ($categories as $category) {
            $list[$category->id] = $category->name;
        }
        
        return $list;
    }
}