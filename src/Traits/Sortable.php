<?php

namespace PISpace\Notion\Traits;

use Illuminate\Support\Collection;
use PISpace\Notion\Core\Properties\BaseNotionProperty;
use PISpace\Notion\Core\Query\NotionSort;

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
