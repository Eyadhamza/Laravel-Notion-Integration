<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\ContentBlock\Block;
use Pi\Notion\Properties\Property;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;
use function PHPUnit\Framework\isNull;

class NotionPage extends Workspace
{
    use RetrieveResource;
    use ThrowsExceptions;

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
        parent::__construct();
        $this->id = $id ;
        $this->URL = Workspace::PAGE_URL;
        $this->type = 'page';
        $this->blocks = new Collection();
        $this->properties = new Collection();

    }

    public function create($notionDatabaseId) : self
    {

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version'=> Workspace::NOTION_VERSION])
            ->post($this->URL,
                [
                    'parent'=> array('database_id' => $notionDatabaseId),
                    'properties' => Property::addPropertiesToPage($this),
                    'children'=> Block::addBlocksToPage($this)
                ]);

        $this->constructObject($response->json());

        return $this;
    }

    public function addBlocks(Collection $blocks): self
    {

        $blocks->map(function ($block){
            $this->blocks->add($block);
        });

        return $this;
    }

    public function addProperties(Collection $properties): self
    {

        $properties->map(function ($property){
            $this->properties->add($property);
        });

        return $this;
    }

    public function search($pageTitle, $sortDirection = 'ascending',$timestamp = 'last_edited_time')
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))->post(Workspace::SEARCH_PAGE_URL,['query'=>$pageTitle,
            'sort'=>[
                'direction'=>$sortDirection,
                'timestamp'=>$timestamp
            ]]);
//        $this->constructPageObject($response->json()); TODO
        return $response->json();

    }

    public function update()
    {
        //TODO
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function setBlocks(Collection $blocks): void
    {
        $this->blocks = $blocks;
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

    public function getProperties(): Collection
    {
        return $this->properties;
    }


}

