<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'causer_id',
        'causer_type',
        'subject_id',
        'subject_type',
        'type',
        'properties'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the causer of the activity.
     */
    public function causer()
    {
        return $this->morphTo();
    }

    /**
     * Get the subject of the activity.
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Create a new user activity log.
     *
     * @param string $type
     * @param string $description
     * @param \Illuminate\Database\Eloquent\Model|null $causer
     * @param \Illuminate\Database\Eloquent\Model|null $subject
     * @param array $properties
     * @return \App\Models\Activity
     */
    public static function log($type, $description, $causer = null, $subject = null, $properties = [])
    {
        return static::create([
            'type' => $type,
            'description' => $description,
            'causer_id' => $causer ? $causer->id : null,
            'causer_type' => $causer ? get_class($causer) : null,
            'subject_id' => $subject ? $subject->id : null,
            'subject_type' => $subject ? get_class($subject) : null,
            'properties' => $properties
        ]);
    }
}
