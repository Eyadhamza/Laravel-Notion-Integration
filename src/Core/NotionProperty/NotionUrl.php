<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionUrl extends BaseNotionProperty
{
    private ?string $link = null;


    protected function buildValue():NotionContent
    {
        return NotionSimpleValue::make($this->link)
            ->setValueType($this->type);
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::URL;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['url'])) {
            return $this;
        }

        $this->link = $response['url'];

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->link = $url;

        return $this;
    }
}
