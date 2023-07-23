<?php

namespace PISpace\Notion\Core;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use PISpace\Notion\Core\RequestBuilders\BaseNotionRequestBuilder;
use PISpace\Notion\Exceptions\NotionException;

class NotionClient
{
    const BASE_URL= 'https://api.notion.com/v1';
    const SEARCH_PAGE_URL =  NotionClient::BASE_URL.'/search';
    const NOTION_VERSION = '2022-06-28';

    private string $token;
    private PendingRequest $client;

    public function __construct()
    {
        $this->token = config('notion-api-wrapper.token');
        $this->client = new PendingRequest();

        $this
            ->setToken()
            ->setHeaders();
    }

    public static function make(): NotionClient
    {
        return new self();
    }

    public function post(string $url, array $body = []): Response
    {
        return $this
            ->client
            ->post($url, $body)
            ->onError(fn($response) => NotionException::matchException($response->json()));
    }

    public function get(string $url, string $param = null, array $queryParams = null): Response
    {
        return $this->client
            ->get($url . $param, $queryParams)
            ->onError(fn($response) => NotionException::matchException($response->json()));

    }

    private function setHeaders(): self
    {
        $this->client->withHeaders([
            'Notion-Version' => self::NOTION_VERSION
        ]);

        return $this;
    }

    private function setToken(): self
    {
        $this->client->withToken($this->token);
        return $this;
    }
    public function matchMethod(string $getMethod, string $url, ?array $body = null): Response
    {
        return match ($getMethod) {
            'get' => $this->get(url: $url, queryParams: $body),
            'post' => $this->post($url, $body),
            'patch' => $this->patch($url, $body),
        };
    }

    public function patch(string $url, array $body = []): Response
    {
        return $this
            ->client
            ->patch($url, $body)
            ->onError(fn($response) => NotionException::matchException($response->json()));

    }

    public function delete(string $url): Response
    {
        return $this
            ->client
            ->delete($url)
            ->onError(fn($response) => NotionException::matchException($response->json()));
    }


}
