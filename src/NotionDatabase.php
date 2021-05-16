<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;

class NotionDatabase extends Workspace
{
    use ThrowsExceptions;
    use RetrieveResource;

    public function __construct($id = '')
    {
        parent::__construct();

        $this->id = $id ;
        $this->URL = $this->BASE_URL."/databases/";

    }


    public function getContents(array $filter , $id = null,array|string $sorts = [],$filterType = '')
    {
        $id = $id ?? $this->id;

        $response = Http::withToken(config('notion-wrapper.info.token'))

            ->post("$this->URL"."$id"."/query",
                empty($filterType) ? $this->filter($filter) : $this->multipleFilters($filter,$filterType));



        $this->throwExceptions($response);

        return $response->json();

    }


    public function filter($filter): array
    {

       return [
           'filter'=>[
               'property'=>$filter['property'],
                'select'=>[
                    'equals'=>$filter['select']
                ]
            ],
       ];
    }
    public function multipleFilters($filters,$filterType): array
    {

        $filters = collect($filters);
        // the power of collections!
        return [
            'filter' =>[
            $filterType =>
                $filters->map(function ($filter){
                    return ['property'=>$filter['property'],
                        'select'=>[
                            'equals'=>$filter['select']

                        ]
                    ];
                })
                ]

        ];
    }
}
