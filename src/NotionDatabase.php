<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;

class NotionDatabase extends Workspace
{
    private string $id;
    private string $DATABASE_URL;
    public function __construct($id = '')
    {
        parent::__construct();

        $this->id = $id ;
        $this->DATABASE_URL = $this->BASE_URL."/databases/";

    }

    public function get($id = null)
    {

        $id = $id ?? $this->id;

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get("$this->DATABASE_URL"."$id");

        $this->throwExceptions($response);

        return $response->json();

    }
    # usage :
    # $filter['property'] = 'status'
    # $filter['select'] = 'Reading'
    # NotionDatabase('asdasd')->getContents($filter,)
    public function getContents(array $filter = null, $id = null,array|string $sorts = [],$filterType = '')
    {
        $id = $id ?? $this->id;

//        $property = $filter['property'];
//
//        $select = $filter['select'];

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->post("$this->DATABASE_URL"."$id"."/query",[
                'filter'=>[
                    'property'=>'Status',
                    'select'=>[
                        'equals'=>'Reading'
                    ]
                ]
            ]);




        dd($response->json());
        $this->throwExceptions($response);

        return $response->json();

    }
    public function throwExceptions($response)
    {
        if ($response->status() == 400){
            throw NotionDatabaseException::notFound($this->id);
        }
        if ($response->status() == 401){
            throw NotionDatabaseException::notAuthorized();
        }
    }
}
