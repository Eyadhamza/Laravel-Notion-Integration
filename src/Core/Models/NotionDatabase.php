<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\NotionDatabaseDescription;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\RequestBuilders\NotionDatabaseRequestBuilder;
use Pi\Notion\Core\RequestBuilders\NotionUpdateDatabaseRequestBuilder;
use Pi\Notion\NotionClient;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\HandleSorts;

class NotionDatabase extends NotionObject
{
    use HandleFilters, HandleProperties, HandleSorts;

    private string $link;
    protected NotionDatabaseTitle $title;
    protected ?NotionDatabaseDescription $description;

    protected Collection $properties;
    protected Collection $pages;
    protected Collection $filters;

    public function __construct($id = '')
    {
        $this->id = $id;
        $this->properties = new Collection();
        $this->pages = new Collection();
        $this->filters = new Collection();
        $this->sorts = new Collection();
    }


    public static function find($id): self
    {
        return (new NotionDatabase($id))->get();
    }


    public function get(): self
    {
        $response = NotionClient::make()->get(NotionClient::BASE_URL . '/databases/', $this->id);

        return $this->fromResponse($response->json());

    }

    public function create(): self
    {
        $requestBuilder = NotionDatabaseRequestBuilder::make($this->title, $this->getParentPageId(), $this->properties);

        $response = NotionClient::make()
            ->setRequest($requestBuilder)
            ->post(NotionClient::BASE_URL . '/databases/');

        return $this->fromResponse($response->json());
    }


    public function update(): self
    {
        $requestBuilder = NotionUpdateDatabaseRequestBuilder::make(
            $this->title,
            $this->description,
            $this->getProperties()
        );

        $response = NotionClient::make()
            ->setRequest($requestBuilder)
            ->patch(NotionClient::BASE_URL . '/databases/' . $this->id);

        return $this->fromResponse($response->json());

    }

    public function query(int $pageSize = 100, string $startCursor = null): NotionPaginator
    {
        $requestBody = [];

        if (isset($this->filters) && $this->filters->isNotEmpty()) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts) && $this->sorts->isNotEmpty()) $requestBody['sorts'] = $this->getSortResults();

        $this->paginator = new NotionPaginator();

        $response = $this->paginator
            ->setUrl(NotionClient::BASE_URL . '/databases/' . $this->id . '/query')
            ->setMethod('post')
            ->setBody($requestBody)
            ->setPageSize($pageSize)
            ->setPaginatedObject(new NotionPage)
            ->setStartCursor($startCursor)
            ->paginate();

        return $this->paginator->make($response);
    }


    public static function fromResponse($response): static
    {
        $database = parent::fromResponse($response);
        $database->title = NotionDatabaseTitle::make($response['title'][0]['plain_text']) ?? null;
        if (! empty($response['description'])){
            $database->description = NotionDatabaseDescription::make($response['description'][0]['plain_text']) ?? null;
        }
        $database->url = $response['url'] ?? null;
        $database->icon = $response['icon'] ?? null;
        $database->cover = $response['cover'] ?? null;
        $database->buildProperties($response);

        return $database;
    }


    public function setDatabaseId(string $id): self
    {
        $this->id = $id;

        return $this;
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

    public function setTitle(NotionDatabaseTitle $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
    public function setProperties(array $properties): self
    {
        collect($properties)->map(function ($property) {
            $this->properties->add($property);
        });
        return $this;
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function setDatabaseDescription(NotionDatabaseDescription $description): static
    {
        $this->description = $description;

        return $this;
    }

}
