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

    private mixed $id;
    private string $URL;

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

    public function getContents($filters , $id = null, string $sort = '', $filterType = '')
    {
        $id = $id ?? $this->id;
        $queryURL = "$this->URL"."$id"."/query";
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->post($queryURL,
                empty($filterType) ?
                    $this->filter($filters) : $this->multipleFilters($filters,$filterType)
            );
        $this->throwExceptions($response);
        return $response->json();

    }

    public function filter($property): array
    {
       return [
           'filter'=> $this->setFilterInterface($property->filter)->setPropertyFilter($property)
       ];
    }

    public function multipleFilters($properties,$filterType): array
    {

        return [
            'filter' => [
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
