<?php

namespace PISpace\Notion\Core\Query;

use PISpace\Notion\Core\Models\NotionDatabase;
use PISpace\Notion\Core\Models\NotionObject;
use PISpace\Notion\Core\Models\NotionPage;
use PISpace\Notion\Core\NotionClient;
use PISpace\Notion\Traits\Sortable;

class NotionSearch
{
    use Sortable;

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
                'sort' => $this->sortUsingTimestamp(),
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
