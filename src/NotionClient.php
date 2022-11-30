<?php

namespace Pi\Notion;

use Illuminate\Support\Facades\Http;
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
    const DATABASE_URL = NotionClient::BASE_URL.'/databases/';
    const NOTION_VERSION = '2022-02-22';

    private string $token;

    public function __construct()
    {
        $token = \config('notion-wrapper.info.token');
        $this->token = $token;
    }
    public static function client(): self
    {
        return new self();
    }
    /**
     * @throws ObjectNotFoundException
     * @throws InvalidRequestException
     * @throws InternalServerErrorException
     * @throws InvalidRequestUrlException
     * @throws MissingVersionException
     * @throws RateLimitedException
     * @throws ServiceUnavailableException
     * @throws UnauthorizedException
     * @throws InvalidJsonException
     * @throws RestrictedResourceException
     * @throws NotionValidationException
     * @throws ConflictErrorException
     */
    public static function request(string $method, string $url, array $requestBody = []): array
    {
        return Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version' => \Pi\Notion\NotionClient::NOTION_VERSION])
            ->$method($url, $requestBody)
            ->onError(fn($response) => NotionException::matchException($response->json()))
            ->json();
    }
}
