<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionEmail extends BaseNotionProperty
{
    protected function buildValue(): NotionContent
    {
        $this->blockContent = NotionSimpleValue::make($this->value)
            ->setValueType($this->type);

        return $this->blockContent;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['email'])) {
            return $this;
        }
        $this->value = $response['email'];
        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::EMAIL;

        return $this;
    }

    public function setEmail(string $email): NotionEmail
    {
        $this->value = $email;
        return $this;
    }

}
