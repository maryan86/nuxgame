<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'random_number',
        'is_win',
        'win_amount',
    ];

    protected $casts = [
        'is_win'     => 'boolean',
        'win_amount' => 'decimal:2',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
