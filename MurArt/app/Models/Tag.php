<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// class Tag extends Model
// {
//     use HasFactory;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'name',
//     ];

//     /**
//      * Get all designs that have this tag.
//      */
//     public function designs(): BelongsToMany
//     {
//         return $this->belongsToMany(Design::class)->withTimestamps();
//     }
// }