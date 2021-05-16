<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;

class NotionPage
{
    use RetrieveResource;
    use ThrowsExceptions;
    public function __construct($id = '')
    {

        # It's more common for an integration to receive a page ID by calling the search endpoint.
        $this->id = $id ;
        $this->URL = (new Workspace)->BASE_URL."/pages/";

    }

    public function create($notionDatabaseId,array|string $properties,array|string $content = null)
    {

        dd($this->createProperties($properties));
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->post($this->URL,
                ['parent'=> $notionDatabaseId, $this->createProperties($properties), !empty($content) ? $this->createContent($properties,$content) : '']);


        dd($response->json());
        $this->throwExceptions($response);

        return $response->json();
    }

    public function createProperties(array|string $properties)
    {

        $properties = collect($properties);
//        dd($properties);
        // the power of collections!
        return [
            'properties' =>[
                $properties->map(function ($property){

                        return
                            $property['name'] == 'Name' ? array($property['name'] => [
                                'title'=>[
                                    $property['type'] => $property['content'] ?? null
                                ]
                            ]) : array([
                                $property['name'] => [
                                    $property['type'] == 'select' ? array($property['type'] => array(
                                        $property['id'] ?? null,
                                        $property['select_name'] ?? null,
                                        $property['color'] ?? null
                                        )) :
                                        array( $property['type'] => $property['content'] ?? null)
                                ]

                            ])
                        ;
                    })
            ]

        ];
        //TODO
    }

    public function createContent(array|string $properties, array|string $children)
    {
        //TODO
    }

}
//{
//    "parent": {
//        "database_id": "632b5fb7e06c4404ae12065c48280e4c"
//    },
//    "properties": {
//
//        "Name": {
//            "title": [
//                {
//                    "text": {
//                        "content": "New Media Article"
//                    }
//                }
//            ]
//        },
//        "Status": {
//            "select": {
//                "id": "8c4a056e-6709-4dd1-ba58-d34d9480855a",
//                "name": "Ready to Start",
//                "color": "yellow"
//            }
//        },
//        "Publisher": {
//            "select": {
//                "id": "01f82d08-aa1f-4884-a4e0-3bc32f909ec4",
//                "name": "The Atlantic",
//                "color": "red"
//            }
//        }
//
//    },
//    "children": [
//        {
//            "object": "block",
//            "type": "heading_2",
//            "heading_2": {
//                "text": [
//                    {
//                        "type": "text",
//                        "text": {
//                            "content": "Lacinato kale"
//                        }
//                    }
//                ]
//            }
//        },
//        {
//            "object": "block",
//            "type": "paragraph",
//            "paragraph": {
//                "text": [
//                    {
//                        "type": "text",
//                        "text": {
//                            "content": "Lacinato kale is a variety of kale with a long tradition in Italian cuisine, especially that of Tuscany. It is also known as Tuscan kale, Italian kale, dinosaur kale, kale, flat back kale, palm tree kale, or black Tuscan palm.",
//                            "link": {
//                                "url": "https://en.wikipedia.org/wiki/Lacinato_kale"
//                            }
//                        }
//                    }
//                ]
//            }
//        }
//    ]
//}
