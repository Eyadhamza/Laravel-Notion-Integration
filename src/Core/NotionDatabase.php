<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use Pi\Notion\Exceptions\NotionException;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;

class NotionDatabase extends NotionObject
{
    use HandleFilters, HandleProperties;

    private string $link;
    protected string $title;
    protected ?string $description;

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


    public static function find($id): self
    {
        return (new NotionDatabase($id))->get();
    }


    public function get(): self
    {

        $response = prepareHttp()->get($this->url())
            ->onError(
                fn($response) => NotionException::matchException($response->json())
            );
        return $this->build($response->json());

    }

    public function create(): self
    {

        $response = prepareHttp()
            ->post(
                NotionWorkspace::DATABASE_URL, [
                    'parent' => [
                        'type' => 'page_id',
                        'page_id' => $this->getParentPageId()
                    ],
                    'title' => $this->mapTitle($this),
                    'properties' => NotionProperty::mapsProperties($this)
                ]
            )
            ->onError(
                fn($response) => NotionException::matchException($response->json())
            );

        return $this->build($response->json());
    }


    public function update(): self
    {
        $requestBody = [];

        if (isset($this->title)) $requestBody['title'] = $this->mapTitle($this);

        if (isset($this->properties)) $requestBody['properties'] = NotionProperty::mapsProperties($this);

        $response = prepareHttp()->patch($this->url(), $requestBody)
            ->onError(
                fn($response) => NotionException::matchException($response->json())
            );

        return $this->build($response->json());

    }

    public function query(): Collection
    {
        $requestBody = [];
        if (isset($this->filters)) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts)) $requestBody['sorts'] = $this->getSortResults();

        $response = prepareHttp()->post($this->queryUrl(), $requestBody)
            ->onError(
                fn($response) => NotionException::matchException($response->json())
            );

        return (new NotionPage)->buildList($response->json());
    }

    private function getSortResults(): array
    {
        return $this->sorts->map->get()->toArray();
    }

    public static function build($response): static
    {
        $database = parent::build($response);
        $database->title = $response['title'][0]['plain_text'] ?? null;
        $database->description = $response['description'][0]['plain_text'] ?? null;
        $database->url = $response['url'] ?? null;
        $database->icon = $response['icon'] ?? null;
        $database->cover = $response['cover'] ?? null;
        $database->buildProperties($response);

        return $database;
    }


    public function sorts(array|NotionSort $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
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
        return NotionWorkspace::DATABASE_URL . $this->id;
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
