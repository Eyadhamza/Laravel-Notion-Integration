<?php

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Workspace;

if (! function_exists('prepareHttp')) {
    function prepareHttp(): PendingRequest
    {
        return Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version' => Workspace::NOTION_VERSION]);
    }
}
