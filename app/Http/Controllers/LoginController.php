<?php

namespace App\Http\Controllers;

use App\Components\MailerLite\MailerLite;
use App\Http\Requests\LoginRequest;
use App\Services\AccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('subscribers');
        }
        return view('pages.login');
    }

    /**
     * @param LoginRequest $loginRequest
     * @param AccountService $accountService
     * @return RedirectResponse
     */
    public function authenticate(LoginRequest $loginRequest, AccountService $accountService): RedirectResponse
    {
        try {
            $apiKey = $loginRequest->getFormData()['api_key'] ?? null;
            $accountService->setMailerLite(
                App::makeWith(MailerLite::class, ['options' => ['api_key' => $apiKey], 'httpLayer' => null])
            );
            $owner = $accountService->getOwnerDataByApiKey();

            Auth::login(
                $accountService->upsertUserWithApiKey($apiKey, $owner)
            );

            return redirect()->route('subscribers');

        } catch (\Throwable $e) {
            return back()->withErrors([
                'api_key' => 'The provided api key do not match our records.',
            ])->onlyInput('email');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
