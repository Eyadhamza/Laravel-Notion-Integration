<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionLastEditedBy extends BaseNotionProperty
{

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['last_edited_by'])) {
            return $this;
        }

        $this->lastEditedBy = NotionUser::make($response['last_edited_by']['id'])
            ->fromResponse($response['last_edited_by']);

        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::LAST_EDITED_BY;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'value' => $this->lastEditedBy
        ];
    }
}

