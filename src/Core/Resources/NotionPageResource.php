<?php

namespace Pi\Notion\Core\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Models\NotionBlock;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\Properties\BaseNotionProperty;

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
