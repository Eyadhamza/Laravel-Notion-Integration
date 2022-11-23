<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\RetrieveResource;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionDatabase extends Workspace
{
    use ThrowsExceptions;
    use HandleFilters;

    private string $id;
    private string $created_time;
    private string $last_edited_time;
    private string $title;
    private Collection $properties;
    private Collection $pages;
    private Collection $filters;
    private Collection $sorts;
    private mixed $objectType;

    public function __construct($id = '', $title = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->properties = new Collection();
        $this->pages = new Collection();
    }

    public function get()
    {
        $response = prepareHttp()
            ->get($this->getUrl());

        $this->throwExceptions($response);

        return $response->json();

    }
    public function query()
    {
        $requestBody = [];
        isset($this->filters) ? $requestBody['filter'] = $this->getFilterResults() : null;
        isset($this->sorts) ? $requestBody['sorts'] = $this->getSortResults() : null;

        $response = prepareHttp()
            ->post($this->queryUrl(), $requestBody);

        $this->throwExceptions($response);

        return $response->json();

    }

    public function sort(Collection|array $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
    }

    public function usingConnective(string $connective): self
    {
        $this->filters[0]->setConnective($connective);

        return $this;
    }

    public function setDatabaseId(string $notionDatabaseId)
    {
        $this->id = $notionDatabaseId;
    }

    public function getDatabaseId(): string
    {
        return $this->id;
    }

    private function getSortResults(): array
    {
        return $this->sorts->map->get()->toArray();
    }

    private function getUrl(): string
    {
        return Workspace::DATABASE_URL . $this->id;
    }

    private function queryUrl(): string
    {
      return $this->getUrl() . "/query";
    }
}
