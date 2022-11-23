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
    private string $URL;
    private mixed $created_time;
    private mixed $last_edited_time;
    private Collection $blocks;
    private Collection $properties;
    private mixed $archived;


    public function __construct($id = '')
    {
        $this->id = $id;
        $this->URL = Workspace::PAGE_URL;
        $this->type = 'page';
        $this->blocks = new Collection();
        $this->properties = new Collection();

    }
    public function get()
    {

    }

    public function create(): self
    {
        $response = $this
            ->prepareHttp()
            ->post($this->URL, [
                'parent' => array('database_id' => $this->notionDatabase->getDatabaseId()),
                'properties' => Property::mapsPropertiesToPage($this),
                'children' => Block::mapsBlocksToPage($this)
            ]);
        return $this;
    }

    public function update(): self
    {
        $response = $this->prepareHttp()
            ->patch($this->URL . $this->id, [
                'properties' => Property::mapsPropertiesToPage($this),
            ]);

        return $this;
    }

    public function search(string $pageTitle)
    {

        $response = $this->prepareHttp()
            ->post(Workspace::SEARCH_PAGE_URL,
                [
                    'query' => $pageTitle
                ]);

//      $this->constructPageObject($response->json());
        return $response->json();

    }


    public function constructObject(mixed $json): self
    {
        $this->type = 'page';
        $this->id = $json['id'];
        $this->created_time = $json['created_time'];
        $this->last_edited_time = $json['last_edited_time'];
        $this->archived = $json['archived'];
        return $this;

    }

    private function prepareHttp(): PendingRequest
    {
        return Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version' => Workspace::NOTION_VERSION]);
    }

    public function setDatabaseId(string $notionDatabaseId): void
    {
        $this->notionDatabase = new NotionDatabase($notionDatabaseId);
    }

}
