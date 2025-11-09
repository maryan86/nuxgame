<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService
    ) {}

    public function index(): View
    {
        return view('home');
    }

    public function register(RegistrationRequest $request): RedirectResponse
    {
        $result = $this->registrationService->register($request->validated());

        return redirect($result['url'])
            ->with('success', 'Registration successful! Your unique link is valid for 7 days.');
    }
}
