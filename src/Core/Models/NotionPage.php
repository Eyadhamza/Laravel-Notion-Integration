<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\Builders\CreateNotionPageRequestBuilder;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\HandleBlocks;
use Pi\Notion\Traits\HandleProperties;

class NotionPage extends NotionObject
{
    use HandleProperties, HandleBlocks;

    private string $notionDatabaseId;
    protected Collection $blocks;
    protected Collection $properties;

    public function __construct($id = '')
    {
        $this->id = $id;
        $this->blocks = new Collection();
        $this->properties = new Collection();
    }

    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->lastEditedBy = new NotionUser($response['last_edited_by']['id'] ?? '') ?? null;
        $this->url = $response['url'] ?? null;
        $this->icon = $response['icon'] ?? null;
        $this->cover = $response['cover'] ?? null;

        $this->properties = new Collection();
        $this->buildProperties($response);
        return $this;
    }

    public function get(): self
    {
        $response = NotionClient::make()->get($this->getUrl());

        return $this->fromResponse($response->json());
    }

    public function getProperty(string $name, int $pageSize = 100): BaseNotionProperty|NotionPaginator
    {
        /** @var BaseNotionProperty $property */
        $property = $this->properties->get($name);

        if ($property->isPaginated()) {
            return NotionPaginator::make(BaseNotionProperty::class)
                ->setUrl($this->propertyUrl($property->getId()))
                ->setMethod('get')
                ->paginate($pageSize);
        }

        $response = NotionClient::make()
            ->get($this->propertyUrl($property->getId()))
            ->json();

        return NotionPropertyFactory::make(NotionPropertyTypeEnum::from($response['type']), $response['id'])
            ->fromResponse($response);
    }

    public function getWithContent(): NotionPaginator
    {
        return (new NotionBlock)->getChildren($this->id);
    }

    public static function find($id): self
    {
        return (new NotionPage($id))->get();
    }

    public static function findContent($id): NotionPaginator
    {
        return (new NotionPage($id))->getWithContent();
    }

    public function create(): self
    {
        $requestBuilder = CreateNotionPageRequestBuilder::make()
            ->setParent($this->notionDatabaseId)
            ->setProperties($this->properties)
            ->setBlocks($this->blocks);

        $response = NotionClient::make()
            ->post(NotionClient::PAGE_URL, $requestBuilder->build());

        return $this->fromResponse($response->json());
    }

    public function update(): self
    {
        $requestBuilder = CreateNotionPageRequestBuilder::make()
            ->setProperties($this->properties);

        $response = NotionClient::make()
            ->patch($this->getUrl(), $requestBuilder->build());

        return $this->fromResponse($response->json());
    }

    public function delete(): NotionBlock
    {
        return (new NotionBlock)
            ->setId($this->id)
            ->delete();
    }

    public function setDatabaseId(string $notionDatabaseId): self
    {
        $this->notionDatabaseId = $notionDatabaseId;
        return $this;
    }

    private function getUrl(): string
    {
        return NotionClient::PAGE_URL . $this->id;
    }

    private function propertyUrl($id): string
    {
        return $this->getUrl() . '/properties/' . $id;
    }

    public function ofPropertyName(string $name)
    {
        return $this->properties->filter(function (BaseNotionProperty $property) use ($name) {
            return $property->getName() == $name;
        })->first();
    }
}
