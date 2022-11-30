<?php

namespace Pi\Notion;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Core\NotionWorkspace;
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
            ->withHeaders(['Notion-Version' => NotionWorkspace::NOTION_VERSION])
            ->$method($url, $requestBody)
            ->onError(fn($response) => NotionException::matchException($response->json()))
            ->json();
    }
}
