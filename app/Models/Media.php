<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['strategy_id', 'path', 'type'];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
}
