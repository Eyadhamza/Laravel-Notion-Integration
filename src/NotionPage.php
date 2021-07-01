<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\ContentBlock\Block;
use Pi\Notion\Properties\Property;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;

class NotionPage extends Workspace
{
    use RetrieveResource;
    use ThrowsExceptions;


    protected mixed $created_time;
    protected mixed $last_edited_time;

    private Collection $blocks;

    public function __construct($id = '')
    {


        # It's more common for an integration to receive a page ID by calling the search endpoint.
        parent::__construct();
        $this->id = $id ;
        $this->URL = Workspace::PAGE_URL;
        $this->blocks = new Collection();

    }


    public function createPage($notionDatabaseId, Collection $properties)
    {

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version'=> Workspace::NOTION_VERSION])
            ->post($this->URL,
                [
                    'parent'=> array('database_id' => $notionDatabaseId),
                    'properties' => Property::addPropertiesToPage($properties),
                    'children'=> Block::addBlocksToPage($this)
                ]);


        return $response->json();
    }

    // TODO createPageWithProperties
    // TODO createPageWithBlocks
    public function addBlock(Block $block): self
    {

        $this->blocks->add($block);

        return $this;

    }

    public function search($pageTitle, $sortDirection = 'ascending',$timestamp = 'last_edited_time')
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))->post(Workspace::SEARCH_PAGE_URL,['query'=>$pageTitle,
            'sort'=>[
                'direction'=>$sortDirection,
                'timestamp'=>$timestamp
            ]]);

        return $response->json();

    }



    public function update()
    {
        //TODO
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function setBlocks(Collection $blocks): void
    {
        $this->blocks = $blocks;
    }





}

