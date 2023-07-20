<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\Query\NotionSort;

trait Sortable
{
    protected Collection $sorts;

    public function setSorts(array $sorts): self
    {
        $this->sorts = collect($sorts)
            ->map(fn(BaseNotionProperty $property) => NotionSort::make($property)->resource());

        return $this;
    }

    public function setSort(BaseNotionProperty $property): self
    {
        $this->sorts->add(NotionSort::make($property)->resource());

        return $this;
    }
    private function sortUsingTimestamp(): array
    {
        return [
            'timestamp' => 'last_edited_time',
            'direction' => 'descending',
        ];
    }

}
