<?php

namespace Pi\Notion;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Core\NotionWorkspace;
use Pi\Notion\Exceptions\NotionException;

class NotionClient
{

    public static function request(string $method, string $url, array $requestBody = []): array
    {
        return Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version' => NotionWorkspace::NOTION_VERSION])
            ->$method($url, $requestBody)
            ->onError(
                fn($response) => NotionException::matchException($response->json())
            )->json();
    }
}
