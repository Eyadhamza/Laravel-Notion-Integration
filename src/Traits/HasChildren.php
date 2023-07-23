<?php

namespace PISpace\Notion\Traits;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Builders\NotionBlockBuilder;

trait HasChildren
{

    /**
     * @var Collection<NotionContent>
     */
    private Collection $children;

    public function setBlockBuilder(NotionBlockBuilder $childrenBuilder): self
    {
        $this->children = $childrenBuilder->getBlocks();

        return $this;
    }

    public function getChildren(): array|MissingValue
    {
        if ($this->children->isEmpty()) {
            return new MissingValue();
        }

        return $this
            ->children
            ->flatten()
            ->map(fn(NotionContent $child) => $child->resource())
            ->all();
    }
}
