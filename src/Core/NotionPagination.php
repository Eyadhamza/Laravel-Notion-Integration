<?php

namespace Pi\Notion\Core;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionException;

class NotionPagination
{
    private ?string $startCursor;
    private ?int $pageSize = 100;

    private bool $hasMore;
    private ?string $nextCursor;
    private Collection $results;
    private string $resultsType;
    private string $objectType;
    private string $url;
    private string $method;


    public function make($response, NotionObject $notionObject): static
    {
        $this->hasMore = $response['has_more'];
        $this->nextCursor = $response['next_cursor'];

        $this->resultsType = $response['type'];
        $this->objectType = $response['object'];
        $this->results = new Collection();
        foreach ($response['results'] as $result) {
            $this->results->add($notionObject::build($result));
        }
        return $this;
    }
    public function get()
    {
        $method = $this->getMethod();
        $response = Http::prepareHttp()
            ->$method($this->getUrl(),
                $this->getPaginationParameters()
            )->onError(
                fn($response) => NotionException::matchException($response->json())
            );
        $this->updateNextCursor($response->json()['next_cursor'], $response->json()['has_more']);
        return $response;
    }
    public function setPageSize(int $pageSize): static
    {
        $this->pageSize = $pageSize;
        return $this;
    }
    public function next(): static
    {
        $this->startCursor = $this->getNextCursor();
        $this->get();
        return $this;
    }
    public function getNextCursor(): ?string
    {
        return $this->nextCursor;
    }
    public function getHasMore(): bool
    {
        return $this->hasMore;
    }
    public function getStartCursor(): ?string
    {
        return $this->startCursor ?? null;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }
    public function getPaginationParameters(): array
    {

        return [
            'page_size' => $this->getPageSize(),
            'start_cursor' => $this->getStartCursor(),
        ];
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    private function updateNextCursor(string $nextCursor = null,bool $hasMore = false): void
    {
        $this->nextCursor = $nextCursor;
        $this->hasMore = $hasMore;
    }
}
