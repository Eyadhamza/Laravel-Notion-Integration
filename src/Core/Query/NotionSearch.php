<?php

namespace Pi\Notion\Core\Query;

use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Traits\HandleSorts;

class NotionSearch extends NotionObject
{
    use HandleSorts;

    private string $query;
    private string $filteredClass;

    public function __construct(string $query = '', string $filterObject = '')
    {
        $this->query = $query;
        $this->filteredClass = $filterObject;
    }

    public static function make($query, $filterObject): self
    {
        return new NotionSearch($query, $filterObject);
    }

    public static function inPages(string $query): self
    {
        return new self($query, NotionPage::class);
    }

    public static function inDatabases(string $query): self
    {
        return new self($query, NotionDatabase::class);
    }

    public function apply(int $pageSize = 100): NotionPaginator
    {
        return NotionPaginator::make($this->filteredClass)
            ->setUrl(NotionClient::SEARCH_PAGE_URL)
            ->setMethod('post')
            ->setBody([
                'query' => $this->query,
                'filter' => [
                    'value' => $this->getFilterObject($this->filteredClass),
                    'property' => 'object'
                ],
                'sort' => $this->getSortUsingTimestamp()
            ])
            ->setPageSize($pageSize)
            ->paginate();

    }

    public function setQuery(string $query): NotionSearch
    {
        $this->query = $query;
        return $this;
    }

    public function setFilteredClass(string $filteredClass): NotionSearch
    {
        $this->filteredClass = $filteredClass;
        return $this;
    }

    private function getFilterObject($objectName): string
    {
        return match ($objectName) {
            NotionPage::class => 'page',
            NotionDatabase::class => 'database',
        };
    }
}
