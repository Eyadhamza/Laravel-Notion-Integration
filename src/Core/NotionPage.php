<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
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

    public function getWithContent(): Collection
    {
        return (new NotionBlock)->get($this->id);
    }

    public function create(): self
    {
//        dd(NotionBlock::mapsBlocksToPage($this))    ;
        $response = prepareHttp()
            ->post(NotionWorkspace::PAGE_URL, [
                'parent' => array('database_id' => $this->getDatabaseId()),
                'properties' => NotionProperty::mapsProperties($this),
                'children' => NotionBlock::mapsBlocksToPage($this)
            ]);
        dd($response->json());
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
        return (new NotionBlock)->delete($this->id);
    }

    public function search(string $pageTitle)
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
