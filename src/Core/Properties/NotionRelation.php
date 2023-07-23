<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Content\NotionArrayValue;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionRelation extends BaseNotionProperty
{
    private ?array $pageIds = null;
    private ?string $singleProperty = null;
    private ?string $dualProperty = null;
    private ?string $databaseId = null;

    public function setPageIds(array $pageIds): static
    {
        $this->pageIds = $pageIds;
        return $this;
    }

    public function setRelationSingleProperty(string $singleProperty): self
    {
        $this->singleProperty = $singleProperty;
        return $this;
    }

    public function setRelationDualProperty(string $dualProperty): self
    {
        $this->dualProperty = $dualProperty;
        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::RELATION;

        return $this;
    }

    public function setDatabaseId(string $databaseId): self
    {
        $this->databaseId = $databaseId;

        return $this;
    }

    public function mapToResource(): array
    {
        if (isset($this->pageIds)) {
            return collect($this->pageIds)
                ->map(fn($pageId) => ['id' => $pageId])
                ->all();
        }
        return [
            'database_id' => $this->databaseId,
            'single_property' => $this->singleProperty ?? new \stdClass(),
        ];
    }
}

