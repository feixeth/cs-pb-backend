<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['strategy_id', 'path', 'type'];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
}
