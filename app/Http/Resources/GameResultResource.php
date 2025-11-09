<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResultResource extends JsonResource
{
    public const RESULT_WIN = 'Win';
    public const RESULT_LOSE = 'Lose';

    public function toArray(Request $request): array
    {
        return [
            'random_number' => $this->random_number,
            'is_win' => $this->is_win,
            'result' => $this->is_win ? self::RESULT_WIN : self::RESULT_LOSE,
            'win_amount' => number_format($this->win_amount, 2, '.', ''),
        ];
    }
}
