<?php

namespace App\Services;

use App\Models\GameResult;
use App\Models\Link;
use App\Repositories\GameResultRepository;
use App\Repositories\LinkRepository;
use Illuminate\Support\Collection;

class GameService
{
    public function __construct(
        private GameResultRepository $gameResultRepository,
        private LinkRepository $linkRepository
    ) {}

    public function playByToken(string $token): ?GameResult
    {
        $link = $this->getValidLink($token);

        if (!$link) {
            return null;
        }

        return $this->play($link);
    }

    public function getHistoryByToken(string $token, int $limit = 3): ?Collection
    {
        $link = $this->getValidLink($token);

        if (!$link) {
            return null;
        }

        return $this->gameResultRepository->getLatestByLink($link->id, $limit);
    }

    private function play(Link $link): GameResult
    {
        $randomNumber = rand(1, 1000);
        $isWin = $randomNumber % 2 === 0;
        $winAmount = $isWin ? $this->calculateWinAmount($randomNumber) : 0;

        return $this->gameResultRepository->create([
            'link_id' => $link->id,
            'random_number' => $randomNumber,
            'is_win' => $isWin,
            'win_amount' => $winAmount,
        ]);
    }

    private function getValidLink(string $token): ?Link
    {
        $link = $this->linkRepository->findValidByToken($token);

        if (!$link || !$link->isValid()) {
            return null;
        }

        return $link;
    }

    private function calculateWinAmount(int $number): float
    {
        if ($number > 900) {
            return $number * 0.7;
        }

        if ($number > 600) {
            return $number * 0.5;
        }

        if ($number > 300) {
            return $number * 0.3;
        }

        return $number * 0.1;
    }
}