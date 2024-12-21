<?php

namespace App\Http\Controllers;

use App\Services\Auth\CallbackGoogleService;
use App\Services\Auth\RedirectToGoogleService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    private RedirectToGoogleService $redirectToGoogleService;
    private CallbackGoogleService $callbackGoogleService;

    public function __construct(
        RedirectToGoogleService $redirectToGoogleService,
        CallbackGoogleService   $callbackGoogleService,
    )
    {
        $this->redirectToGoogleService = $redirectToGoogleService;
        $this->callbackGoogleService = $callbackGoogleService;
    }

    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return $this->redirectToGoogleService->redirectToGoogle();
    }

    public function callbackGoogle(): string|\Illuminate\Http\RedirectResponse|null
    {
        return $this->callbackGoogleService->callbackGoogle();
    }
}
