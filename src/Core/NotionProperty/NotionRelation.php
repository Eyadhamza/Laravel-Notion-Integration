<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;

class NotionRelation extends BaseNotionProperty
{
    private ?array $pageIds = null;
    private ?string $databaseId = null;

    public function setPageIds(array $pageIds): static
    {
        $this->pageIds = $pageIds;
        return $this;
    }

    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make(array_merge($this->getIds(),[
            'database_id' => $this->databaseId ?? new MissingValue(),
            'single_property' => $this->singleProperty ?? new MissingValue(),
        ]))->setType('relation');
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

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['relation'])) {
            return $this;
        }
        $this->databaseId = $response['relation']['database_id'] ?? null;

        $this->pageIds = collect($response['relation'])
            ->filter(fn ($value, $key) => is_string($key))
            ->map(fn ($page) => $page['id'])->all();

        return $this;
    }

    private function getIds(): array
    {
        if (!$this->pageIds) {
            return [];
        }

        return collect($this->pageIds)
            ->map(fn ($id) => ['id' => $id])
            ->all();
    }
}

