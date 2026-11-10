<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NotesUiTest extends TestCase
{
    private function apiUrl(string $path): string
    {
        return rtrim(config('services.notes_api.url'), '/').'/'.$path;
    }

    private function apiSession(string $role = 'user'): array
    {
        return [
            'api_token' => 'test-token',
            'api_user' => ['_id' => 'u1', 'name' => 'Alice', 'email' => 'alice@example.com', 'role' => $role],
        ];
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/notes')->assertRedirect(route('login'));
    }

    public function test_login_stores_the_token_in_the_session(): void
    {
        Http::fake([
            $this->apiUrl('auth/login') => Http::response([
                'token' => 'jwt-token',
                'user' => ['_id' => 'u1', 'name' => 'Alice', 'email' => 'alice@example.com', 'role' => 'user'],
            ]),
        ]);

        $this->post('/login', ['email' => 'alice@example.com', 'password' => 'Password@123'])
            ->assertRedirect(route('notes.index'))
            ->assertSessionHas('api_token', 'jwt-token');
    }

    public function test_failed_login_shows_the_api_error(): void
    {
        Http::fake([
            $this->apiUrl('auth/login') => Http::response(['message' => 'Invalid email or password'], 401),
        ]);

        $this->from('/login')
            ->post('/login', ['email' => 'alice@example.com', 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('api')
            ->assertSessionMissing('api_token');
    }

    public function test_notes_page_lists_notes_with_the_bearer_token(): void
    {
        Http::fake([
            $this->apiUrl('notes*') => Http::response([
                'data' => [[
                    '_id' => 'n1', 'title' => 'First note', 'content' => 'Hello',
                    'createdAt' => now()->toIso8601String(), 'updatedAt' => now()->toIso8601String(),
                ]],
                'meta' => ['page' => 1, 'limit' => 10, 'total' => 1, 'totalPages' => 1],
            ]),
        ]);

        $this->withSession($this->apiSession())
            ->get('/notes')
            ->assertOk()
            ->assertSee('First note');

        Http::assertSent(fn (Request $request) => $request->hasHeader('Authorization', 'Bearer test-token'));
    }

    public function test_expired_token_logs_the_user_out(): void
    {
        Http::fake([$this->apiUrl('notes*') => Http::response(['message' => 'Invalid or expired token'], 401)]);

        $this->withSession($this->apiSession())
            ->get('/notes')
            ->assertRedirect(route('login'))
            ->assertSessionMissing('api_token');
    }

    public function test_admin_pages_are_hidden_from_regular_users(): void
    {
        $this->withSession($this->apiSession('user'))->get('/admin/users')->assertForbidden();
    }

    public function test_admin_can_open_the_user_list(): void
    {
        Http::fake([
            $this->apiUrl('users*') => Http::response([
                'data' => [['_id' => 'u2', 'name' => 'Bob', 'email' => 'bob@example.com', 'role' => 'user', 'interests' => ['chess']]],
                'meta' => ['page' => 1, 'limit' => 10, 'total' => 1, 'totalPages' => 1],
            ]),
        ]);

        $this->withSession($this->apiSession('admin'))
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('bob@example.com');
    }
}
