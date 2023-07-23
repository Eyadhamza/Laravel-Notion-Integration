<?php

namespace PISpace\Notion\Traits\Filters;

trait HasDateFilters
{
   use HasEqualityFilters, HasExistenceFilters;

    public function before(string $query): self
    {
        return $this->applyFilter('before', $query);
    }

    public function after(string $query): self
    {
        return $this->applyFilter('after', $query);
    }

    public function onOrBefore(string $query): self
    {
        return $this->applyFilter('on_or_before', $query);
    }

    public function onOrAfter(string $query): self
    {
        return $this->applyFilter('on_or_after', $query);
    }

    public function pastWeek(string $query): self
    {
        return $this->applyFilter('past_week', $query);
    }

    public function pastMonth(string $query): self
    {
        return $this->applyFilter('past_month', $query);
    }

    public function pastYear(string $query): self
    {
        return $this->applyFilter('past_year', $query);
    }

    public function nextWeek(string $query): self
    {
        return $this->applyFilter('next_week', $query);
    }

    public function nextMonth(string $query): self
    {
        return $this->applyFilter('next_month', $query);
    }

    public function nextYear(string $query): self
    {
        return $this->applyFilter('next_year', $query);
    }

    public function thisWeek(string $query): self
    {
        return $this->applyFilter('this_week', $query);
    }

}
