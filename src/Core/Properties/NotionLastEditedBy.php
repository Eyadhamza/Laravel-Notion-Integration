<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionLastEditedBy extends BaseNotionProperty
{

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['last_edited_by'])) {
            return $this;
        }

        $this->value = NotionUser::make($response['last_edited_by']['id'])
            ->fromResponse($response['last_edited_by']);

        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::LAST_EDITED_BY;

        return $this;
    }

}

