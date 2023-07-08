<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionObjectValue;
use stdClass;

class NotionEmail extends BaseNotionProperty
{
    private string $email;

    protected function buildValue()
    {
        $this->value = NotionObjectValue::make($this->email)->type('email');

        return $this->value;
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
