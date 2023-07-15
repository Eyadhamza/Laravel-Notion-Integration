<?php

namespace Pi\Notion\Traits;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionContent;

trait HasChildren
{

    /**
     * @var Collection<NotionContent>
     */
    private Collection $children;

    public function setChildren(array $children): self
    {
        $this->children = collect($children);
        return $this;
    }

    public function getChildren(): array|MissingValue
    {
        if ($this->children->isEmpty()) {
            return new MissingValue();
        }

        return $this
            ->children
            ->map(fn(NotionContent $child) => $child->resource())
            ->all();
    }
}
