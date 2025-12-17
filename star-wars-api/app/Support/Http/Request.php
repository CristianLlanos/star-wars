<?php

namespace App\Support\Http;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Fluent HTTP Request builder using Laravel's HTTP client.
 */
class Request
{
    private string $basePath;

    private string $method = 'GET';

    private string $path = '';

    /** @var array<string, string> */
    private array $headers = [];

    /** @var array<string, mixed> */
    private array $query = [];

    /** @var array<string, mixed> */
    private array $body = [];

    private int $retries = 3;

    private int $retryDelayMs = 500;

    public static function new(string $basePath): self
    {
        return new self($basePath);
    }

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path): self
    {
        $this->method = 'GET';
        $this->path = $path;

        return $this;
    }

    public function post(string $path): self
    {
        $this->method = 'POST';
        $this->path = $path;

        return $this;
    }

    public function addQuery(string $key, mixed $value): self
    {
        $this->query[$key] = $value;

        return $this;
    }

    public function addBody(string $key, mixed $value): self
    {
        $this->body[$key] = $value;

        return $this;
    }

    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function retries(int $times, int $delayMs = 500): self
    {
        $this->retries = $times;
        $this->retryDelayMs = $delayMs;

        return $this;
    }

    public function send(): Response
    {
        $client = Http::retry($this->retries, $this->retryDelayMs)->acceptJson();

        if (! empty($this->headers)) {
            $client = $client->withHeaders($this->headers);
        }

        $url = $this->buildUrl();

        if ($this->method === 'GET') {
            return $client->get($url, $this->query);
        }

        return $client->send($this->method, $url, [
            'query' => $this->query,
            'json' => $this->body,
        ]);
    }

    private function buildUrl(): string
    {
        return $this->basePath.'/'.ltrim($this->path, '/');
    }
}
