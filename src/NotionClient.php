<?php

namespace Pi\Notion;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Pi\Notion\Core\RequestBuilders\BaseNotionRequestBuilder;
use Pi\Notion\Core\RequestBuilders\NotionDatabaseRequestBuilder;
use Pi\Notion\Exceptions\ConflictErrorException;
use Pi\Notion\Exceptions\InternalServerErrorException;
use Pi\Notion\Exceptions\InvalidJsonException;
use Pi\Notion\Exceptions\InvalidRequestException;
use Pi\Notion\Exceptions\InvalidRequestUrlException;
use Pi\Notion\Exceptions\MissingVersionException;
use Pi\Notion\Exceptions\NotionException;
use Pi\Notion\Exceptions\NotionValidationException;
use Pi\Notion\Exceptions\ObjectNotFoundException;
use Pi\Notion\Exceptions\RateLimitedException;
use Pi\Notion\Exceptions\RestrictedResourceException;
use Pi\Notion\Exceptions\ServiceUnavailableException;
use Pi\Notion\Exceptions\UnauthorizedException;

class NotionClient
{
    const BASE_URL= 'https://api.notion.com/v1';
    const PAGE_URL = NotionClient::BASE_URL.'/pages/';
    const BLOCK_URL = NotionClient::BASE_URL.'/blocks/';
    const SEARCH_PAGE_URL =  NotionClient::BASE_URL.'/search';
    const NOTION_VERSION = '2022-06-28';
    const COMMENTS_URL =  NotionClient::BASE_URL.'/comments/';

    private string $token;
    private PendingRequest $client;
    private BaseNotionRequestBuilder $requestBuilder;

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
            ->post($url, array_merge($this->requestBuilder->build(), $body))
            ->onError(fn($response) => NotionException::matchException($response->json()));
    }

    public function get(string $url, string $param, array $queryParams = null): Response
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

    public function setRequest(BaseNotionRequestBuilder $requestBuilder): static
    {
        $this->requestBuilder = $requestBuilder;
        return $this;
    }

    public function matchMethod(string $getMethod, string $url, ?array $body = null): Response
    {
        return match ($getMethod) {
            'get' => $this->get($url, $body),
            'post' => $this->post($url, $body),
        };
    }

    public function patch(string $url): Response
    {
        return $this
            ->client
            ->post($url, $this->requestBuilder->build())
            ->onError(fn($response) => NotionException::matchException($response->json()));

    }


}
