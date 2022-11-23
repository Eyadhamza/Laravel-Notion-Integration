<?php


namespace Pi\Notion;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
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
    private string $type;
    private string $id;
    private Collection $blocks;
    private Collection $properties;


    public function __construct($id = '')
    {
        $this->id = $id;
        $this->type = 'page';
        $this->blocks = new Collection();
        $this->properties = new Collection();

    }
    public function get()
    {
        $response = prepareHttp()->get($this->getUrl());

        $this->throwExceptions($response);

        return $this;
    }

    public function create(): self
    {
        $response = prepareHttp()
            ->post(Workspace::PAGE_URL, [
                'parent' => array('database_id' => $this->notionDatabase->getDatabaseId()),
                'properties' => Property::mapsProperties($this),
                'children' => Block::mapsBlocksToPage($this)
            ]);
        return  $this;
    }

    public function update(): self
    {
        $response = prepareHttp()
            ->patch($this->getUrl(), [
                'properties' => Property::mapsProperties($this),
            ]);

        return  $this;
    }

    public function delete(): self
    {
        $response = prepareHttp()
            ->delete(Workspace::BLOCK_URL . $this->id);
        return  $this;
    }
    public function search(string $pageTitle)
    {

        $response = prepareHttp()
            ->post(Workspace::SEARCH_PAGE_URL, ['query' => $pageTitle]);

        return $this;

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
