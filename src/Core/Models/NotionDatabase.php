<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Properties\BaseNotionProperty;
use Pi\Notion\Core\Properties\NotionDatabaseDescription;
use Pi\Notion\Core\Properties\NotionDatabaseTitle;
use Pi\Notion\Core\Properties\NotionSelect;
use Pi\Notion\Core\Properties\NotionTitle;
use Pi\Notion\Core\Query\NotionFilter;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\RequestBuilders\NotionDatabaseRequestBuilder;
use Pi\Notion\Core\RequestBuilders\NotionUpdateDatabaseRequestBuilder;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\Sortable;

class NotionDatabase extends NotionObject
{
    use HandleProperties, Sortable;

    const DATABASE_URL = NotionClient::BASE_URL . '/databases/';
    private string $link;
    protected NotionTitle|NotionDatabaseTitle $title;
    protected ?NotionDatabaseDescription $description;
    protected Collection $properties;
    protected Collection $pages;
    protected Collection $filters;

    public function __construct(string $id = null)
    {
        parent::__construct($id);
        $this->properties = new Collection();
        $this->pages = new Collection();
        $this->filters = new Collection();
        $this->sorts = new Collection();
    }


    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->title = NotionTitle::make($response['title'][0]['plain_text']) ?? null;
        if (!empty($response['description'])) {
            $this->description = NotionDatabaseDescription::make($response['description'][0]['plain_text']) ?? null;
        }
        $this->url = $response['url'] ?? null;
        $this->icon = $response['icon'] ?? null;
        $this->cover = $response['cover'] ?? null;
        $this->properties = new Collection();
        $this->buildPropertiesFromResponse($response);

        return $this;
    }

    public function find(): self
    {
        $response = NotionClient::make()->get(self::DATABASE_URL, $this->id);

        return $this->fromResponse($response->json());
    }

    public function create(): self
    {
        $requestBuilder = NotionDatabaseRequestBuilder::make($this->title, $this->getParentPageId(), $this->properties);

        $response = NotionClient::make()
            ->post(self::DATABASE_URL, $requestBuilder->build());

        return $this->fromResponse($response->json());
    }

    public function update(): self
    {
        $requestBuilder = NotionUpdateDatabaseRequestBuilder::make(
            $this->title,
            $this->description,
            $this->properties
        );

        $response = NotionClient::make()
            ->patch(self::DATABASE_URL . $this->id, $requestBuilder->build());

        return $this->fromResponse($response->json());

    }

    public function query(int $pageSize = 100, string $startCursor = null): NotionPaginator
    {
        $requestBody = [];

        if ($this->filters->isNotEmpty()) {
            $requestBody['filter'] = $this->filters->first();
        }

        if ($this->sorts->isNotEmpty()) {
            $requestBody['sorts'] = $this->sorts->all();
        }
//        dd($requestBody);
        return NotionPaginator::make(NotionPage::class)
            ->setUrl(self::DATABASE_URL . $this->id . '/query')
            ->setMethod('post')
            ->setBody($requestBody)
            ->setPageSize($pageSize)
            ->setStartCursor($startCursor)
            ->paginate();
    }

    public function getParentPageId(): string
    {
        return $this->parentId;
    }

    public function setParentPageId(string $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function setTitle(NotionTitle|NotionDatabaseTitle $title): self
    {
        $this->title = $title->buildContent();

        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function setDatabaseDescription(NotionDatabaseDescription $description): static
    {
        $this->description = $description->buildContent();

        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = collect($filters);

        return $this;
    }

    public function setFilter(BaseNotionProperty $property): self
    {
        $this->filters->add(NotionFilter::make($property)->resource());

        return $this;
    }

}
