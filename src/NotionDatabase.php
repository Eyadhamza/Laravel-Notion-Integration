<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionDatabase
{
    use ThrowsExceptions;
    use HandleFilters;
    use HandleProperties;

    private string $parentPageId;
    private string $id;
    private string $title;
    private string $link;

    private Collection $properties;
    private Collection $pages;
    private Collection $filters;
    private Collection $sorts;

    public function __construct($id = '')
    {
        $this->id = $id;
    }

    public function get()
    {
        $response = prepareHttp()
            ->get(
                $this->url()
            );

        $this->throwExceptions($response);

        return $response->json();

    }

    public function query()
    {
        $requestBody = [];
        if (isset($this->filters)) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts)) $requestBody['sorts'] = $this->getSortResults();

        $response = prepareHttp()->post($this->queryUrl(), $requestBody);

        $this->throwExceptions($response);

        return $response->json();
    }

    public function sort(Collection|array $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
    }

    public function create(): array
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

        return $response->json();
    }

    public function update()
    {
        $requestBody = [];

        if (isset($this->title)) $requestBody['title'] = $this->mapTitle($this);

        if (isset($this->properties)) $requestBody['properties'] = Property::mapsProperties($this);

        $response = prepareHttp()->patch($this->url(), $requestBody);
        $this->throwExceptions($response);

        return $response->json();

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
        return $this->parentPageId;
    }

    public function setParentPageId(string $parentPageId): self
    {
        $this->parentPageId = $parentPageId;

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
