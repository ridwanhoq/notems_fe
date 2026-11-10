<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NotesApi
{
    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $uri, array $query = []): array
    {
        return $this->send('get', $uri, $query);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function post(string $uri, array $data = []): array
    {
        return $this->send('post', $uri, $data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function patch(string $uri, array $data = []): array
    {
        return $this->send('patch', $uri, $data);
    }

    /**
     * @return array<string, mixed>
     */
    public function delete(string $uri): array
    {
        return $this->send('delete', $uri);
    }

    private function client(): PendingRequest
    {
        $request = Http::baseUrl(config('services.notes_api.url'))
            ->acceptJson()
            ->asJson()
            ->timeout((int) config('services.notes_api.timeout'));

        if ($token = session('api_token')) {
            $request = $request->withToken($token);
        }

        return $request;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function send(string $method, string $uri, array $data = []): array
    {
        try {
            /** @var Response $response */
            $response = $this->client()->{$method}(ltrim($uri, '/'), $data);
        } catch (ConnectionException) {
            throw new ApiException(503, 'The notes API is not reachable.');
        }

        if ($response->failed()) {
            throw new ApiException(
                $response->status(),
                $response->json('message') ?? 'Request failed.',
                $response->json('errors') ?? [],
            );
        }

        return $response->json() ?? [];
    }
}
