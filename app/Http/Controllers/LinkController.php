<?php

namespace App\Http\Controllers;

use App\Repositories\LinkRepository;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function __construct(
        private LinkRepository $linkRepository,
        private LinkService    $linkService
    )
    {
    }

    public function show(string $token): View|RedirectResponse
    {
        $link = $this->linkRepository->findValidByToken($token);

        if (!$link || !$link->isValid()) {
            return redirect()->route('home')
                ->with('error', 'This link is invalid or has expired.');
        }

        return view('link', compact('link'));
    }

    public function regenerate(string $token): RedirectResponse
    {
        $link = $this->linkRepository->findValidByToken($token);

        if (!$link) {
            return redirect()->route('home')
                ->with('error', 'Invalid link.');
        }

        $result = $this->linkService->regenerateLink($link);

        return redirect($result['url'])
            ->with('success', 'Link regenerated successfully!');
    }

    public function deactivate(string $token): RedirectResponse
    {
        $link = $this->linkRepository->findByToken($token);

        if (!$link) {
            return redirect()->route('home')
                ->with('error', 'Invalid link.');
        }

        $this->linkService->deactivateLink($link);

        return redirect()->route('home')
            ->with('success', 'Link deactivated successfully.');
    }
}
