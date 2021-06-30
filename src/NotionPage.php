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

    private $content;
    public function __construct($id = '',$content ='')
    {


        # It's more common for an integration to receive a page ID by calling the search endpoint.
        parent::__construct();
        $this->id = $id ;
        $this->URL = $this->BASE_URL."/pages/";


        $this->content = $content;
    }


    public function create($notionDatabaseId,Collection $properties)
    {


        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version'=>'2021-05-13'])
            ->post($this->URL,
                [
                    'parent'=> array('database_id' => $notionDatabaseId),
                    'properties' => Property::add($properties),
                    'children'=> $this->content
                    ]);

        dump($response->json());
        return $response->json();
    }

    public function addContentBody(string $body): self
    {
       (new Block)->addBlockBody($body);

        return $this;
    }

    public function ofType(string $type): self
    {
        (new Block)->addBlockType($type);

        return $this;
    }


    public function search($pageTitle, $sortDirection = 'ascending',$timestamp = 'last_edited_time')
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))->post($this->BASE_URL."/search",['query'=>$pageTitle,
            'sort'=>[
                'direction'=>$sortDirection,
                'timestamp'=>$timestamp
            ]]);

        return $response->json();

    }

    public function getBlocks()
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get($this->BASE_URL."/blocks/$this->id/children");

        return $response->json();
    }
    public function update()
    {
        //TODO
    }
    public function isSelectProperty($property)
    {
       return $property->getType() == 'select';
    }

    public function isNameProperty($property)
    {
        return $property->getName() == 'Name';
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    private function fillPage()
    {


    }



}

