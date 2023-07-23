<?php

namespace PISpace\Notion\Core\RequestBuilders;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;

abstract class BaseNotionRequestBuilder
{
    use ConditionallyLoadsAttributes;

    public function build(): array
    {
        return $this->filter($this->toArray());
    }
    abstract public function toArray();
}
