<?php

namespace Pi\Notion\Core\RequestBuilders;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Models\NotionObject;

class PaginatorRequestBuilder extends BaseNotionRequestBuilder
{
    private NotionObject $notionObject;
    private ?string $startCursor;
    private ?int $pageSize;

    public function __construct(NotionObject $notionObject)
    {
        $this->notionObject = $notionObject;
    }

    public static function make(NotionObject $notionObject): static
    {
        return new static($notionObject);
    }

    public function toArray(): array
    {
        return [
            'start_cursor' => $this->startCursor ?? new MissingValue(),
            'page_size' => $this->pageSize,
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
