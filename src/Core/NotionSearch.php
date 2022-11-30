<?php

namespace Pi\Notion\Core;

use Pi\Notion\Traits\HandleSorts;

class NotionSearch extends NotionObject
{
    use HandleSorts;

    private string $query;
    private string $filterObject;

    public function __construct(string $query = '', string $filterObject = '')
    {
        $this->query = $query;
        $this->filterObject = $filterObject;
    }

    public static function make($query, $filterObject): self
    {
        return new NotionSearch($query, $filterObject);
    }
    public function apply(int $pageSize = 100): NotionPagination
    {

        $this->pagination = new NotionPagination();
        $response = $this->pagination
            ->setUrl(NotionWorkspace::SEARCH_PAGE_URL)
            ->setMethod('post')
            ->setRequestBody([
                'query' => $this->query,
                'filter' => [
                    'value' => $this->filterObject,
                    'property' => 'object'
                ],
                'sort' => $this->getSortUsingTimestamp()[0]
            ])
            ->setPageSize($pageSize)
            ->paginate();

        return $this->pagination->make($response, $this->getFilterObject($this->filterObject));

    }

    public function setQuery(string $query): NotionSearch
    {
        $this->query = $query;
        return $this;
    }

    public function setFilterObject(string $filterObject): NotionSearch
    {
        $this->filterObject = $filterObject;
        return $this;
    }

    private function getFilterObject($objectName)
    {
        return match ($objectName){
            'page' => new NotionPage,
            'database' => new NotionDatabase
        };
    }
}
