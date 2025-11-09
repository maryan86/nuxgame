<?php

namespace App\Repositories;

use App\Models\Link;
use Carbon\Carbon;

class LinkRepository
{
    public function create(int $userId, string $token): Link
    {
        return Link::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => Carbon::now()->addDays(7),
            'is_active' => true,
        ]);
    }

    public function findByToken(string $token): ?Link
    {
        return Link::where('token', $token)->first();
    }

    public function findValidByToken(string $token): ?Link
    {
        return Link::where('token', $token)
            ->where('is_active', true)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    public function deactivate(Link $link): bool
    {
        return $link->update(['is_active' => false]);
    }

    public function regenerate(Link $oldLink, string $newToken): Link
    {
        $this->deactivate($oldLink);

        return $this->create($oldLink->user_id, $newToken);
    }
}