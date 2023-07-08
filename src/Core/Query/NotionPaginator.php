<?php

namespace Pi\Notion\Core\Query;

use Illuminate\Support\Collection;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\RequestBuilders\PaginatorRequestBuilder;
use Pi\Notion\NotionClient;

class NotionPaginator
{
    private ?string $startCursor;
    private ?int $pageSize = 100;
    private bool $hasMore;
    private ?string $nextCursor;
    private Collection $results;
    private string $url;
    private string $method;
    private array $requestBody;

    private NotionObject $notionObject;

    public function make(array $response): static
    {
        $this->hasMore = $response['has_more'];
        $this->nextCursor = $response['next_cursor'];
        $this->results = new Collection();
        foreach ($response['results'] as $result) {
            $this->results->add($this->notionObject::fromResponse($result));
        }
        return $this;
    }

    public function paginate(): array
    {
        $paginatorRequestBuilder = PaginatorRequestBuilder::make($this->notionObject)
            ->setStartCursor($this->startCursor)
            ->setPageSize($this->pageSize);

        $response = NotionClient::make()
            ->setRequest($paginatorRequestBuilder)
            ->matchMethod($this->method, $this->url, $this->requestBody);

        $this->updateNextCursor($response['next_cursor'], $response['has_more']);

        return $response->json();
    }

    public function next(): static
    {
        $this->startCursor = $this->getNextCursor();
        $this->make($this->paginate());
        return $this;
    }

    private function updateNextCursor(string $nextCursor = null, bool $hasMore = false): void
    {
        $this->nextCursor = $nextCursor;
        $this->hasMore = $hasMore;
    }

    public function setPageSize(int $pageSize): static
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    public function getNextCursor(): ?string
    {
        return $this->nextCursor;
    }

    public function hasMore(): bool
    {
        return $this->hasMore;
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

    public function getResults(): Collection
    {
        return $this->results;
    }

    public function getAllResults(): Collection
    {
        while ($this->hasMore()) {
            $this->results = $this->results->merge($this->next()->getResults());
        }
        return $this->results;
    }

    public function setBody(array $requestBody): static
    {
        $this->requestBody = $requestBody;
        return $this;
    }

    public function setPaginatedObject(NotionPage $paginatedObject): static
    {
        $this->notionObject = $paginatedObject;
        return $this;
    }

    public function setStartCursor(?string $startCursor): static
    {
        $this->startCursor = $startCursor;
        return $this;
    }
}
