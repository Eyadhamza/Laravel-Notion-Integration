<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use PhpParser\Builder\Property;
use Pi\Notion\Traits\HandleBlocks;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionPage extends NotionObject
{
    use ThrowsExceptions;
    use HandleProperties;
    use HandleBlocks;


    private string $notionDatabaseId;
    protected Collection $blocks;
    protected Collection $properties;


    public function __construct($id = '')
    {
        $this->id = $id;
        $this->blocks = new Collection();
        $this->properties = new Collection();
    }

    public static function build($response): static
    {

        $page = parent::build($response);
        $page->lastEditedBy = new NotionUser($response['last_edited_by']['id'] ?? '') ?? null;
        $page->url = $response['url'] ?? null;
        $page->icon = $response['icon'] ?? null;
        $page->cover = $response['cover'] ?? null;

        $page->properties = new Collection();
        $page->buildProperties($response);
        return $page;
    }

    public function get()
    {
        $response = prepareHttp()->get($this->getUrl());

        $this->throwExceptions($response);
        return $this->build($response->json());
    }
    public function getProperty(string $name)
    {
        $property = $this
            ->properties
            ->filter
            ->ofName($name)
            ->firstOrFail();

        $response = prepareHttp()->get($this->getUrl() . '/properties/' . $property->getId());

        $property->setValues($response->json()[$property->getType()] ?? []);

        if ($property->isPaginated()) {
            NotionProperty::buildList($response->json());
        }

        $this->throwExceptions($response);

        return $property;
    }
    public function getWithContent(): Collection
    {
        return (new NotionBlock)->getChildren($this->id);
    }

    public static function find($id): self
    {
        return (new NotionPage($id))->get();
    }
    public static function findContent($id): Collection
    {
        return (new NotionPage($id))->getWithContent();
    }
    public function create(): self
    {
        $response = prepareHttp()
            ->post(NotionWorkspace::PAGE_URL, [
                'parent' => array('database_id' => $this->getDatabaseId()),
                'properties' => NotionProperty::mapsProperties($this),
                'children' => NotionBlock::mapsBlocksToPage($this)
            ]);
        $this->throwExceptions($response);

        return $this->build($response->json());
    }

    public function update(): self
    {
        $response = prepareHttp()
            ->patch($this->getUrl(), [
                'properties' => NotionProperty::mapsProperties($this),
            ]);
        $this->throwExceptions($response);
        return $this->build($response->json());
    }

    public function delete(): NotionBlock
    {
        return (new NotionBlock)
            ->setId($this->id)
            ->delete();
    }

    public function search(string $pageTitle): Collection
    {

        $response = prepareHttp()
            ->post(NotionWorkspace::SEARCH_PAGE_URL, ['query' => $pageTitle]);
        $this->throwExceptions($response);
        return $this->buildList($response->json());

    }


    public function setDatabaseId(string $notionDatabaseId): void
    {
        $this->notionDatabaseId = $notionDatabaseId;
    }

    private function getUrl(): string
    {
        return NotionWorkspace::PAGE_URL . $this->id;
    }


    private function getDatabaseId()
    {
        return $this->notionDatabaseId;
    }

}
