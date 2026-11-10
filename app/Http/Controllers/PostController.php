<?php

namespace App\Http\Controllers;

use App\Services\NotesApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private NotesApi $api) {}

    public function index(Request $request): View
    {
        return view('posts.index', $this->api->get('posts', $request->only('page')));
    }

    public function byUser(Request $request, string $userId): View
    {
        return view('posts.user', $this->api->get("posts/user/{$userId}", $request->only('page')));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string', 'max:20000'],
        ]);

        $this->api->post('posts', $data);

        return redirect()->route('posts.index')->with('status', 'Post published.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->api->delete("posts/{$id}");

        return back()->with('status', 'Post deleted.');
    }
}
