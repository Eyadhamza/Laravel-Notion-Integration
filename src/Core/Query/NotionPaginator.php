<?php

namespace Pi\Notion\Core\Query;

use Illuminate\Support\Collection;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\RequestBuilders\PaginatorRequestBuilder;
use Pi\Notion\Enums\NotionPaginatedObjectTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPaginator
{
    public string $paginatedClass;
    private ?string $startCursor;
    private ?int $pageSize = 100;
    private bool $hasMore;
    private ?string $nextCursor = null;
    private Collection $results;
    private string $url;
    private string $method;
    private array $requestBody;

    public function __construct(string $paginatedClass)
    {
        $this->paginatedClass = $paginatedClass;
        $this->results = new Collection();

    }

    public static function make(string $paginatedClass): static
    {
        return new static($paginatedClass);
    }

    public function paginate(): self
    {
        $paginatorRequestBuilder = PaginatorRequestBuilder::make()
            ->setStartCursor($this->startCursor ?? null)
            ->setPageSize($this->pageSize ?? null);

        $response = NotionClient::make()
            ->matchMethod($this->method, $this->url, array_merge($this->requestBody ?? [], $paginatorRequestBuilder->build()));

        $this->updateNextCursor($response['next_cursor'], $response['has_more']);

        return $this->build($response->json());
    }

    public function build(array $response): static
    {
        $this->hasMore = $response['has_more'];
        $this->nextCursor = $response['next_cursor'];
        $this->results = collect($response['results']);
        $this->setPaginatedResults($response);

        return $this;
    }

    public function next(): static
    {
        $this->startCursor = $this->getNextCursor();

        $this->paginate();

        return $this;
    }

    private function updateNextCursor(string $nextCursor = null, bool $hasMore = false): void
    {
        $this->nextCursor = $nextCursor;
        $this->hasMore = $hasMore;
    }

    public function setPageSize(int $pageSize = null): static
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

    public function setPaginatedClass(string $paginatedClass): static
    {
        $this->paginatedClass = $paginatedClass;
        return $this;
    }

    public function setStartCursor(?string $startCursor): static
    {
        $this->startCursor = $startCursor;
        return $this;
    }

    private function setPaginatedResults(array $data): self
    {
        return match (NotionPaginatedObjectTypeEnum::from($data['type'])) {
            NotionPaginatedObjectTypeEnum::PROPERTY_ITEM => $this->setPaginatedProperties($data),
            default => $this->setPaginatedObjects($data),
        };
    }

    private function setPaginatedProperties(array $data): self
    {
        $this->results = collect($data['results'])->mapWithKeys(fn($property) => [
            $property['id'] => NotionPropertyFactory::make(
                NotionPropertyTypeEnum::from($property['type']),
                $property['id']
            )->fromResponse($property)
        ]);

        return $this;
    }

    private function setPaginatedObjects(array $data): self
    {
        /** @var NotionObject $notionObject */
        $notionObject = new $this->paginatedClass;

        $this->results = collect($data['results'])
            ->map(fn($object) => $notionObject->fromResponse($object));

        return $this;
    }
}
