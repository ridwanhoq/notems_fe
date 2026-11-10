<?php

namespace App\Http\Controllers;

use App\Services\NotesApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private NotesApi $api) {}

    public function edit(): View
    {
        return view('profile.edit', ['user' => $this->api->get('auth/me')['user']]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'interests' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data['interests'] = $data['interests'] ?? '';
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user = $this->api->patch('auth/me', $data)['user'];
        $request->session()->put('api_user', $user);

        return redirect()->route('profile.edit')->with('status', 'Profile updated.');
    }
}
