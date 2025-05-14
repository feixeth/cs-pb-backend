<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lineup extends Model
{
    use HasFactory;

    protected $fillable = ['strategy_id', 'title', 'image'];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
}
