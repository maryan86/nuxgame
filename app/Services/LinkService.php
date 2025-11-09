<?php

namespace App\Services;

use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Support\Str;

class LinkService
{
    public function __construct(
        private LinkRepository $linkRepository
    ) {}

    public function regenerateLink(Link $link): array
    {
        $newToken = $this->generateUniqueToken();
        $newLink = $this->linkRepository->regenerate($link, $newToken);

        return [
            'link' => $newLink,
            'url' => route('link.show', ['token' => $newToken]),
        ];
    }

    public function deactivateLink(Link $link): bool
    {
        return $this->linkRepository->deactivate($link);
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(32);
        } while ($this->linkRepository->findByToken($token));

        return $token;
    }
}