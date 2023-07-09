<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionEmail extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::EMAIL;

        return $this;
    }

    public function setEmail(string $email): NotionEmail
    {
        $this->rawValue = $email;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'value' => $this->rawValue
        ];
    }
}
