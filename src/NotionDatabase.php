<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionDatabase extends NotionObject
{
    use ThrowsExceptions;
    use HandleFilters;
    use HandleProperties;

    private string $link;

    protected Collection $properties;
    protected Collection $pages;
    protected Collection $filters;
    protected Collection $sorts;

    public function __construct($id = '')
    {
        $this->id = $id;
        $this->properties = new Collection();
        $this->pages = new Collection();
        $this->filters = new Collection();
        $this->sorts = new Collection();
    }

    public function get()
    {

        $response = prepareHttp()->get($this->url());

        $this->throwExceptions($response);

        return $this->build($response->json());

    }

    public function query()
    {
        $requestBody = [];
        if (isset($this->filters)) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts)) $requestBody['sorts'] = $this->getSortResults();

        $response = prepareHttp()->post($this->queryUrl(), $requestBody);
        $this->throwExceptions($response);

        return $this->buildList($response->json());
    }

    public function sort(Collection|array $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
    }

    public function create(): NotionDatabase
    {

        $response = prepareHttp()
            ->post(
                Workspace::DATABASE_URL, [
                    'parent' => [
                        'type' => 'page_id',
                        'page_id' => $this->getParentPageId()
                    ],
                    'title' => $this->mapTitle($this),
                    'properties' => Property::mapsProperties($this)
                ]
            );

        $this->throwExceptions($response);

        return $this->build($response->json());
    }

    public function update()
    {
        $requestBody = [];

        if (isset($this->title)) $requestBody['title'] = $this->mapTitle($this);

        if (isset($this->properties)) $requestBody['properties'] = Property::mapsProperties($this);

        $response = prepareHttp()->patch($this->url(), $requestBody);

        $this->throwExceptions($response);

        return $this->build($response->json());

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

    private function getSortResults(): array
    {
        return $this->sorts->map->get()->toArray();
    }

    private function url(): string
    {
        return Workspace::DATABASE_URL . $this->id;
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

    private function mapTitle(): array
    {
        return
            array(
                array(
                    'type' => 'text',
                    'text' => array(
                        'content' => $this->title ?? 'Untitled Database',
                        'link' => $this->link ?? null
                    )
                )
            );

    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }



}
