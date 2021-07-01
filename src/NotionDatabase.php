<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\Query\Filterable;
use Pi\Notion\Query\MultiSelectFilter;
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
        $this->URL = Workspace::DATABASE_URL;



    }

    public function setFilterInterface(Filterable $filter)
    {
        $this->filter = $filter;

        return $this->filter;
    }

    public function getContents($properties , $id = null,string $sort = '',$filterType = '')
    {
        $id = $id ?? $this->id;


        $response = Http::withToken(config('notion-wrapper.info.token'))

            ->post("$this->URL"."$id"."/query",
                empty($filterType) ? $this->filter($properties) : $this->multipleFilters($properties,$filterType));

        dd($response->json());
        $this->throwExceptions($response);

        return $response->json();

    }


    public function filter($property): array
    {
        dump('hey');
       return [
           'filter'=> $this->setFilterInterface($property->filter)->setPropertyFilter($property)
       ];
    }
    public function multipleFilters($properties,$filterType): array
    {


        return [
            'filter' =>[
            $filterType =>
                $properties->map(function ($property){

                    return $this->setFilterInterface($property->filter)->setPropertyFilter($property);

                })
                ]

        ];
    }

    public function sort()
    {
        // TODO, whenever i return objects !
    }
}
