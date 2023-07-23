<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Models\NotionUser;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionEmptyValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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

