<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
