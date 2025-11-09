<?php

namespace App\Repositories;

use App\Models\GameResult;
use Illuminate\Database\Eloquent\Collection;

class GameResultRepository
{
    public function create(array $data): GameResult
    {
        return GameResult::create($data);
    }

    public function getLatestByLink(int $linkId, int $limit = 3): Collection
    {
        return GameResult::where('link_id', $linkId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}