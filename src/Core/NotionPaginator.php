<?php

namespace Pi\Notion\Core;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionException;
use Pi\Notion\NotionClient;

class NotionPaginator
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
    private array $requestBody;
    private NotionObject $notionObject;

    public function make($response, NotionObject $notionObject): static
    {
        $this->notionObject = $notionObject;
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

    public function paginate(): array
    {
        $body = [];
        if ($this->getPaginationParameters()) {
            $body = array_merge($body, $this->getPaginationParameters());
        }
        if (isset($this->requestBody)) {
            $body = array_merge($body, $this->requestBody);
        }
        $response = NotionClient::request($this->getMethod(), $this->getUrl(), $body);

        $this->updateNextCursor($response['next_cursor'], $response['has_more']);
        return $response;
    }

    public function next(): static
    {
        $this->startCursor = $this->getNextCursor();
        $this->make($this->paginate(), $this->notionObject);
        return $this;
    }

    public function getPaginationParameters(): array|null
    {
        $parameters = [];
        if ($this->getStartCursor()) {
            $parameters['start_cursor'] = $this->getStartCursor();
        }
        if ($this->getPageSize()) {
            $parameters['page_size'] = $this->getPageSize();
        }
        return $this->pageSize == 100 && is_null($this->getStartCursor()) ? null : $parameters;

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

    public function getStartCursor(): ?string
    {
        return $this->startCursor ?? null;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
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

    public function getResults(): Collection
    {
        return $this->results;
    }

    public function setRequestBody(array $array): static
    {
        $this->requestBody = $array;
        return $this;
    }

    public function getResultsType(): string
    {
        return $this->resultsType;
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function getAllResults(): Collection
    {
        while ($this->hasMore()) {
            $this->results = $this->results->merge($this->next()->getResults());
        }
        return $this->results;
    }

    public function getValues()
    {
        return $this->results->first()->getValues()[0]['text']['content'];
    }
}
