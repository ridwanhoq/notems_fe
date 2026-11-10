<?php

namespace App\Http\Controllers;

use App\Services\NotesApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function __construct(private NotesApi $api) {}

    public function index(Request $request): View
    {
        $result = $this->api->get('notes', $request->only('page'));

        return view('notes.index', $result);
    }

    public function create(): View
    {
        return view('notes.form', ['note' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->api->post('notes', $this->validated($request));

        return redirect()->route('notes.index')->with('status', 'Note created.');
    }

    public function show(string $id): View
    {
        return view('notes.show', ['note' => $this->api->get("notes/{$id}")['data']]);
    }

    public function edit(string $id): View
    {
        return view('notes.form', ['note' => $this->api->get("notes/{$id}")['data']]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $this->api->patch("notes/{$id}", $this->validated($request));

        return redirect()->route('notes.index')->with('status', 'Note updated.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->api->delete("notes/{$id}");

        return redirect()->route('notes.index')->with('status', 'Note deleted.');
    }

    public function all(Request $request): View
    {
        $result = $this->api->get('admin/notes', array_filter($request->only('page', 'userId')));

        return view('admin.notes.index', $result + ['userId' => $request->query('userId')]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'content' => ['nullable', 'string', 'max:20000'],
        ]);

        return ['title' => $data['title'], 'content' => $data['content'] ?? ''];
    }
}
