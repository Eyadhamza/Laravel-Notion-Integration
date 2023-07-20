<?php

namespace Pi\Notion\Core\Properties;

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
        $this->value = $email;

        return $this;
    }

}
