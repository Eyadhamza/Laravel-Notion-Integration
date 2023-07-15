<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\Builders\NotionBlockBuilder;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\RequestBuilders\CreateNotionPageRequestBuilder;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\HandleProperties;

class NotionPage extends NotionObject
{
    use HandleProperties;

    const PAGE_URL = NotionClient::BASE_URL . '/pages/';

    private string $notionDatabaseId;
    protected Collection $blocks;
    protected Collection $properties;
    private ?NotionUser $lastEditedBy;

    public function __construct()
    {
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

    public function find(string $id): self
    {
        $response = NotionClient::make()->get(self::PAGE_URL . $id);

        return $this->fromResponse($response->json());
    }

    public function findWithContent(string $id): NotionPaginator
    {
        return (new NotionBlock)->getChildren($id);
    }

    public function create(): self
    {
        $requestBuilder = CreateNotionPageRequestBuilder::make()
            ->setParent($this->notionDatabaseId)
            ->setProperties($this->properties)
            ->setBlocks($this->blocks);

        $response = NotionClient::make()
            ->post(self::PAGE_URL, $requestBuilder->build());

        return $this->fromResponse($response->json());
    }

    public function update(string $id): self
    {
        $requestBuilder = CreateNotionPageRequestBuilder::make()
            ->setProperties($this->properties);

        $response = NotionClient::make()
            ->patch(self::PAGE_URL . $id, $requestBuilder->build());

        return $this->fromResponse($response->json());
    }

    public function delete(string $id): NotionBlock
    {
        return NotionBlock::make(NotionBlockTypeEnum::PAGE)->delete($id);
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

    public function setDatabaseId(string $notionDatabaseId): self
    {
        $this->notionDatabaseId = $notionDatabaseId;
        return $this;
    }

    private function propertyUrl(string $pageId, string $propertyId): string
    {
        return self::PAGE_URL . $pageId . '/properties/' . $propertyId;
    }

    public function setNotionDatabaseId(string $notionDatabaseId): NotionPage
    {
        $this->notionDatabaseId = $notionDatabaseId;
        return $this;
    }

    public function setBlockBuilder(NotionBlockBuilder $blockBuilder): self
    {
        $this->blocks = $blockBuilder->getBlocks();
        return $this;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

}
