<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\Query\Filterable;
use Pi\Notion\Query\FilterMultiSelect;
use Pi\Notion\Traits\ThrowsExceptions;
use Pi\Notion\Traits\RetrieveResource;

class NotionDatabase extends Workspace
{
    use ThrowsExceptions;
    use RetrieveResource;

    private Filterable $filter ;

    public function __construct($id = '')
    {

        parent::__construct();

        $this->id = $id ;
        $this->URL = $this->BASE_URL."/databases/";



    }

    public function setFilter(Filterable $filter)
    {
        $this->filter = $filter;

        return $this->filter;
    }

    public function getContents($properties , $id = null,array|string $sorts = [],$filterType = '')
    {
        $id = $id ?? $this->id;

        $response = Http::withToken(config('notion-wrapper.info.token'))

            ->post("$this->URL"."$id"."/query",
                empty($filterType) ? $this->filter($properties) : $this->multipleFilters($properties,$filterType));



        $this->throwExceptions($response);

        return $response->json();

    }


    public function filter($property): array
    {


       return [
           'filter'=> $this->setFilter($property->filter)->set($property)
       ];
    }
    public function multipleFilters($properties,$filterType): array
    {


        // the power of collections!
        return [
            'filter' =>[
            $filterType =>
                $properties->map(function ($property){

                    return $this->setFilter($property->filter)->set($property);
                })
                ]

        ];
    }
}
