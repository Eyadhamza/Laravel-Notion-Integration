<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionObjectValue;
use stdClass;

class NotionEmail extends BaseNotionProperty
{
    private ?string $email = null;

    protected function buildValue(): NotionBlockContent
    {
        $this->blockContent = NotionObjectValue::make($this->email)->setType('email');

        return $this->blockContent;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['email'])) {
            return $this;
        }
        $this->email = $response['email'];
        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::EMAIL;

        return $this;
    }

    public function setEmail(string $email): NotionEmail
    {
        $this->email = $email;
        return $this;
    }

}
