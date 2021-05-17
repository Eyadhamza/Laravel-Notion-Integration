<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;

class NotionPage extends Workspace
{
    use RetrieveResource;
    use ThrowsExceptions;


    protected mixed $created_time;
    protected mixed $last_edited_time;

    public function __construct($id = '')
    {


        # It's more common for an integration to receive a page ID by calling the search endpoint.
        parent::__construct();
        $this->id = $id ;
        $this->URL = $this->BASE_URL."/pages/";
        $this->fillPage();


    }

    public function create($notionDatabaseId,array|string $properties, $content = null)
    {

        $response = Http::withToken(config('notion-wrapper.info.token'))->withHeaders(['Notion-Version'=>'2021-05-13'])
            ->post($this->URL,
                [
                    'parent'=> array('database_id' => $notionDatabaseId)

                    ,'properties' => $this->addProperties($properties)['properties'],
                    'children' =>$this->addContent($content)['children']]);


        $this->throwExceptions($response);

        return $response->json();
    }

    public function addProperties(array|string $properties)
    {

        $properties = collect($properties);

//        dd($properties);
        // the power of collections!
        return [
            'properties' =>
                $properties->mapToAssoc(function ($property){

                        return
                            [$property['name'] , $this->isNameProperty($property) ? array(
                                'title'=>array([
                                    $property['type'] => ['content' => $property['content']] ?? null,

                                ]
                            )) :
                                 array($property['type'] =>
                                    array(
                                    'name'=>$property['select_name'] ?? null,
                                    'color'=>$property['color']) ?? null
                                ),


                            ];

                    })


        ];

    }

    public function addContent(array|string $children =null)
    {

        if (!$children){
            return array('children'=>[]);
        }
        $children = collect($children);


        return [
            'children' => $children->map(function($child){
               return ['object'=>'block',
                    'type'=>$child['tag_type'],
                    $child['tag_type']=>array('text'=>array([
                    'type'=>$child['content_type'],
                    $child['content_type'] =>[
                        'content'=> $child['content']
                    ]
                ])
                    )];



            })
        ];
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
       return $property['type'] == 'select';
    }

    public function isNameProperty($property)
    {
        return $property['name'] == 'Name';
    }

    private function fillPage()
    {


    }

}

