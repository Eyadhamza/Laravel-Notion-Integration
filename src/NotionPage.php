<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Pi\Notion\Traits\HandleBlocks;
use Pi\Notion\Traits\HandleProperties;
use Pi\Notion\Traits\RetrieveResource;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionPage
{
    use ThrowsExceptions;
    use HandleProperties;
    use HandleBlocks;

    private NotionDatabase $notionDatabase;
    protected Collection $blocks;
    protected Collection $properties;


    public function __construct($id = '')
    {
        $this->id = $id;
        $this->blocks = new Collection();
        $this->properties = new Collection();

    }
    public function get()
    {
        $response = prepareHttp()->get($this->getUrl());

        $this->throwExceptions($response);

        return $response->json();
    }

    public function create(): array
    {
        $response = prepareHttp()
            ->post(Workspace::PAGE_URL, [
                'parent' => array('database_id' => $this->notionDatabase->getDatabaseId()),
                'properties' => Property::mapsProperties($this),
                'children' => Block::mapsBlocksToPage($this)
            ]);

        return $response->json();
    }

    public function update(): array
    {
        $response = prepareHttp()
            ->patch($this->getUrl(), [
                'properties' => Property::mapsProperties($this),
            ]);

        return $response->json();
    }

    public function delete(): array
    {
        $response = prepareHttp()
            ->delete(Workspace::BLOCK_URL . $this->id);

        return $response->json();
    }
    public function search(string $pageTitle)
    {

        $response = prepareHttp()
            ->post(Workspace::SEARCH_PAGE_URL, ['query' => $pageTitle]);

        return $response->json();

    }

    public function setDatabaseId(string $notionDatabaseId): void
    {
        $this->notionDatabase = new NotionDatabase($notionDatabaseId);
    }

    private function getUrl(): string
    {
        return Workspace::PAGE_URL . $this->id;
    }


}
