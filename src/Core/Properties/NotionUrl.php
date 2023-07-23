<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionSimpleValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
