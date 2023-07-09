<?php

namespace Pi\Notion\Traits;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasResource
{

    public function buildResource(): self
    {
        $this->resource = JsonResource::make($this);

        return $this;
    }

    abstract public function toArray(): array;
}
