<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['strategy_id', 'position', 'role', 'tasks'];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
}
