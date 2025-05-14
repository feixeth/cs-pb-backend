<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strategy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'map', 'type', 'slug', 'is_public'
    ];

    protected $casts = [
        'is_public' => 'boolean',
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

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function lineups()
    {
        return $this->hasMany(Lineup::class);
    }

}
