# Notes Frontend

Laravel frontend for the Notes API (`../task_backend`). Pages are plain Blade views.
Every request goes through `App\Services\NotesApi`, which calls the API from the server
and sends the JWT stored in the session as a Bearer token.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve            # http://localhost:8000
```

Set `NOTES_API_URL` in `.env` (default `http://localhost:4000/api`). No local database is
needed; sessions and cache use the file driver.

## Pages

| Page | Who |
|------|-----|
| Login / Register | guests |
| My Notes (list, create, edit, delete) | users and admins |
| Profile (name, password, interests) | users and admins |
| Posts, Posts by user | everyone |
| Users by Interest | logged-in users |
| All Notes, Users (add, edit, delete) | admins |

## Tests

```bash
php artisan test
```

Feature tests fake the API with `Http::fake()`, so the backend does not need to be running.
