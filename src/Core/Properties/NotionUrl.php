<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionSimpleValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionUrl extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::URL;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->value = $url;

        return $this;
    }

}
