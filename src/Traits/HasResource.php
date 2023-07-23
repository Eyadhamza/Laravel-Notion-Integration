<?php

namespace PISpace\Notion\Traits;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasResource
{
    public function resource()
    {
        $this->resource = JsonResource::make($this->value);

        return $this->resource->resolve();
    }
}
