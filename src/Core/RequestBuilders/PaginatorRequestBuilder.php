<?php

namespace PISpace\Notion\Core\RequestBuilders;

use Illuminate\Http\Resources\MissingValue;

class PaginatorRequestBuilder extends BaseNotionRequestBuilder
{
    private ?string $startCursor;
    private ?int $pageSize;

    public static function make(): static
    {
        return new static();
    }

    public function toArray(): array
    {
        return [
            'start_cursor' => $this->startCursor ?? new MissingValue(),
            'page_size' => $this->pageSize ?? new MissingValue(),
        ];
    }

    public function setStartCursor(?string $startCursor = null): static
    {
        $this->startCursor = $startCursor;
        return $this;
    }

    public function setPageSize(?int $pageSize): static
    {
        $this->pageSize = $pageSize;
        return $this;
    }
}
