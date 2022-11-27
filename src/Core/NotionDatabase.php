<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use PhpParser\Builder\Property;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionDatabase extends NotionObject
{
    use ThrowsExceptions, HandleFilters, HandleProperties;

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

    public function get()
    {

        $response = prepareHttp()->get($this->url());

        $this->throwExceptions($response);

        return $this->build($response->json());

    }

    public function query(): Collection
    {
        $requestBody = [];
        if (isset($this->filters)) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts)) $requestBody['sorts'] = $this->getSortResults();

        $response = prepareHttp()->post($this->queryUrl(), $requestBody);
        $this->throwExceptions($response);

        return (new NotionPage)->buildList($response->json());
    }

    public function sorts(array|NotionSort $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
    }

    public function create(): NotionDatabase
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
            );

        $this->throwExceptions($response);

        return $this->build($response->json());
    }

    public function update()
    {
        $requestBody = [];

        if (isset($this->title)) $requestBody['title'] = $this->mapTitle($this);

        if (isset($this->properties)) $requestBody['properties'] = NotionProperty::mapsProperties($this);

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

    public function getProperty(string $name): NotionProperty
    {
        return $this->properties->each(function ($property) use ($name) {
           return $property->getName() == $name ?  $property : null;
        })->firstOrFail();
    }


}
