<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionSort;

trait HandleSorts
{
    protected Collection $sorts;

    public function sorts(array $sorts): self
    {
        $this->sorts = collect($sorts);

        return $this;
    }
    private function getSortResults(): array
    {
        return $this->sorts->map(function (NotionSort $sort) {
            return $sort->get();
        })->toArray();
    }
    private function getSortUsingTimestamp(): array
    {
        if (isset($this->sorts)) {
            return $this->sorts->map(function (NotionSort $sort) {
                return $sort->getUsingTimestamp();
            })->toArray()[0];
        }
        return [
            'timestamp' => 'last_edited_time',
            'direction' => 'descending',
        ];
    }
}
