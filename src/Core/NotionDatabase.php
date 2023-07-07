<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\NotionClient;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\HandleSorts;

class NotionDatabase extends NotionObject
{
    use HandleFilters, HandleProperties, HandleSorts;

    private string $link;
    protected NotionDatabaseTitle $title;
    protected ?string $description;

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

        $response = NotionClient::request('get', $this->url());

        return $this->build($response);

    }

    public function create(): self
    {

        $response = NotionClient::request('post',
            NotionClient::DATABASE_URL, array_merge($this->title->getAttributes(), [
                'parent' => [
                    'type' => 'page_id',
                    'page_id' => $this->getParentPageId()
                ],
                'properties' => BaseNotionProperty::mapsProperties($this)
            ]));


        return $this->build($response);
    }


    public function update(): self
    {
        $requestBody = [];

        if (isset($this->title)) $requestBody['title'] = $this->mapTitle();

        if (isset($this->properties)) $requestBody['properties'] = BaseNotionProperty::mapsProperties($this);

        $response = NotionClient::request('patch', $this->url(), $requestBody);

        return $this->build($response);

    }

    public function query(int $pageSize = 100): NotionPaginator
    {
        $requestBody = [];

        if (isset($this->filters) && $this->filters->isNotEmpty()) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts) && $this->sorts->isNotEmpty()) $requestBody['sorts'] = $this->getSortResults();

        $this->paginator = new NotionPaginator();
        $response = $this->paginator
            ->setUrl($this->queryUrl())
            ->setMethod('post')
            ->setRequestBody($requestBody)
            ->setPageSize($pageSize)
            ->paginate();

        return $this->paginator->make($response, new NotionPage);
    }


    public static function build($response): static
    {
        $database = parent::build($response);
        $database->title = NotionDatabaseTitle::make($response['title'][0]['plain_text']) ?? null;
        $database->description = $response['description'][0]['plain_text'] ?? null;
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

    public function getDatabaseId(): string
    {
        return $this->id;
    }


    private function url(): string
    {
        return NotionClient::DATABASE_URL . $this->id;
    }

    private function queryUrl(): string
    {
        return $this->url() . "/query";
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

}
