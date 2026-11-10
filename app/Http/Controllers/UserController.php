<?php

namespace App\Http\Controllers;

use App\Services\NotesApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private NotesApi $api) {}

    public function index(Request $request): View
    {
        return view('admin.users.index', $this->api->get('users', $request->only('page')));
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->api->post('users', $this->validated($request, creating: true));

        return redirect()->route('users.index')->with('status', 'User created.');
    }

    public function edit(string $id): View
    {
        return view('admin.users.form', ['user' => $this->api->get("users/{$id}")['data']]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $this->api->patch("users/{$id}", $this->validated($request, creating: false));

        return redirect()->route('users.index')->with('status', 'User updated.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->api->delete("users/{$id}");

        return redirect()->route('users.index')->with('status', 'User deleted.');
    }

    public function groupedByInterest(Request $request): View
    {
        $result = $this->api->get('users/grouped-by-interest', array_filter($request->only('page', 'interest')));

        return view('interests', $result + ['interest' => $request->query('interest')]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, bool $creating): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'password' => [$creating ? 'required' : 'nullable', 'string', 'min:8'],
            'role' => ['required', 'in:user,admin'],
            'interests' => ['nullable', 'string', 'max:500'],
        ]);

        $data['interests'] = $data['interests'] ?? '';
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }
}
