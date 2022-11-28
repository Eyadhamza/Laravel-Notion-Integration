<?php

namespace Pi\Notion\Core;

use Illuminate\Support\Collection;

class NotionPagination
{
    private ?string $startCursor;
    private ?int $pageSize;

    private bool $hasMore;
    private ?string $nextCursor;
    private Collection $results;
    private string $resultsType;
    private string $objectType;

    public function __construct(string $startCursor = null, int $pageSize = null)
    {
        $this->startCursor = $startCursor;
        $this->pageSize = $pageSize;
    }

    public static function make($response, NotionObject $paginatedObject)
    {
        $pagination = new static($response['start_cursor'] ?? null, $response['page_size'] ?? null);
        $pagination->hasMore = $response['has_more'];
        $pagination->nextCursor = $response['next_cursor'];
        $pagination->resultsType = $response['type'];
        $pagination->objectType = $response['object'];



        $pagination->results = new Collection();
        foreach ($response['results'] as $result) {
            $pagination->results->add($paginatedObject::build($result));
        }
        return $pagination;
    }
    public function getResults(): Collection
    {
        return $this->results;
    }
}
