<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;

class NotionRelation extends BaseNotionProperty
{
    private string $databaseId;

    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make([
            'database_id' => $this->databaseId,
            'single_property' => new \stdClass()
        ])->type('relation');
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
        $this->databaseId = $response['relation']['database_id'];

        return $this;
    }
}

