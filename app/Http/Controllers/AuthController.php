<?php

namespace App\Http\Controllers;

use App\Services\NotesApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private NotesApi $api) {}

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        return $this->startSession($request, $this->api->post('auth/login', $credentials));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'interests' => ['nullable', 'string', 'max:500'],
        ]);

        $data['interests'] = $data['interests'] ?? '';

        return $this->startSession($request, $this->api->post('auth/register', $data));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * @param  array<string, mixed>  $response
     */
    private function startSession(Request $request, array $response): RedirectResponse
    {
        $request->session()->regenerate();
        $request->session()->put('api_token', $response['token']);
        $request->session()->put('api_user', $response['user']);

        return redirect()->route('notes.index');
    }
}
