<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\NotionProperty\NotionDatabaseDescription;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\RequestBuilders\NotionDatabaseRequestBuilder;
use Pi\Notion\Core\RequestBuilders\NotionUpdateDatabaseRequestBuilder;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\HandleSorts;

class NotionDatabase extends NotionObject
{
    use HandleFilters, HandleProperties, HandleSorts;

    private string $link;
    protected NotionTitle|NotionDatabaseTitle $title;
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
        dd(
            $requestBuilder->toArray()
        );
        $response = NotionClient::make()
            ->post(NotionClient::BASE_URL . '/databases/', $requestBuilder->build());

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
            ->patch(NotionClient::BASE_URL . '/databases/' . $this->id, $requestBuilder->build());

        return $this->fromResponse($response->json());

    }

    public function query(int $pageSize = 100, string $startCursor = null): NotionPaginator
    {
        $requestBody = [];

        if (isset($this->filters) && $this->filters->isNotEmpty()) $requestBody['filter'] = $this->getFilterResults();
        if (isset($this->sorts) && $this->sorts->isNotEmpty()) $requestBody['sorts'] = $this->getSortResults();

        return NotionPaginator::make(NotionPage::class)
            ->setUrl(NotionClient::BASE_URL . '/databases/' . $this->id . '/query')
            ->setMethod('post')
            ->setBody($requestBody)
            ->setStartCursor($startCursor)
            ->paginate($pageSize);
    }


    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->title = NotionTitle::make($response['title'][0]['plain_text']) ?? null;
        if (! empty($response['description'])){
            $this->description = NotionDatabaseDescription::make($response['description'][0]['plain_text']) ?? null;
        }
        $this->url = $response['url'] ?? null;
        $this->icon = $response['icon'] ?? null;
        $this->cover = $response['cover'] ?? null;
        $this->buildProperties($response);

        return $this;
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

    public function setTitle(NotionTitle|NotionDatabaseTitle $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }


    public function setDatabaseDescription(NotionDatabaseDescription $description): static
    {
        $this->description = $description;

        return $this;
    }

}
