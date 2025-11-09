<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use App\Repositories\LinkRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class RegistrationService
{
    public function __construct(
        private UserRepository $userRepository,
        private LinkRepository $linkRepository
    ) {}

    public function register(array $data): array
    {
        $user = $this->userRepository->create([
            'username' => $data['username'],
            'phonenumber' => $data['phonenumber'],
        ]);

        $token = $this->generateUniqueToken();
        $link = $this->linkRepository->create($user->id, $token);

        return [
            'user' => $user,
            'link' => $link,
            'url' => route('link.show', ['token' => $token]),
        ];
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(32);
        } while ($this->linkRepository->findByToken($token));

        return $token;
    }
}