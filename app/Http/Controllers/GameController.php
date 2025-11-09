<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResultResource;
use App\Services\GameService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    use ApiResponses;

    public function __construct(
        private GameService $gameService
    )
    {
    }

    public function play(string $token): JsonResponse
    {
        $result = $this->gameService->playByToken($token);

        if (!$result) {
            return $this->errorResponse('Invalid or expired link', 403);
        }

        return $this->successResponse(
            new GameResultResource($result),
            'Game played successfully'
        );
    }

    public function history(string $token): JsonResponse
    {
        $history = $this->gameService->getHistoryByToken($token);

        if ($history === null) {
            return $this->errorResponse('Invalid or expired link', 403);
        }

        return $this->successResponse(
            GameResultResource::collection($history),
            'Game history retrieved successfully'
        );
    }
}
