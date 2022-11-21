<?php

namespace Pi\Notion\Traits;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Str;

trait NotionFilters
{

    public static function select(string $propertyName): self
    {
        return self::make('select', $propertyName);
    }
    public static function title(string $propertyName): self
    {
        return self::make('title', $propertyName);
    }
    public static function multiSelect(string $propertyName): self
    {
        return self::make('multi_select', $propertyName);
    }

    public function equals(string $query): self
    {

        return $this->apply('equals', $query);
    }

    public function contains(string $query): self
    {
        return $this->apply('contains', $query);
    }
}
