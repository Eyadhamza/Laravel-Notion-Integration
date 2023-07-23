<?php

namespace PISpace\Notion\Core\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Models\NotionBlock;
use PISpace\Notion\Core\Models\NotionPage;
use PISpace\Notion\Core\Properties\BaseNotionProperty;

/* @mixin NotionPage */
class NotionPageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'object' => 'page',
            'id' => $this->getId(),
            'properties' => $this->getProperties()->map(fn(BaseNotionProperty $property) => $property->buildContent()->resource()),
            'blocks' => $this->getBlocks()->map(fn(NotionBlock $block) => $block->getValue()->resource()),
        ];
    }
}
