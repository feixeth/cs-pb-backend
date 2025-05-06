<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'map', 'type', 'is_public', 'slug'
    ];

    protected static function booted()
    {
        static::creating(function ($strategy) {
            $strategy->slug = Str::slug($strategy->title . '-' . uniqid());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function getScoreAttribute()
    {
        return $this->votes()->sum('value');
    }
}
