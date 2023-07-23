<?php

namespace PISpace\Notion\Core\Content;

use PISpace\Notion\Enums\NotionBlockTypeEnum;

class NotionBlockContentFactory
{
    private NotionBlockTypeEnum $type;

    public function __construct(NotionBlockTypeEnum $type)
    {
        $this->type = $type;
    }

    public static function make(NotionBlockTypeEnum $type): NotionContent
    {
        return (new self($type))->match();
    }

    private function match(): NotionContent
    {
        return match (true){
            NotionBlockTypeEnum::isRichText($this->type) => NotionRichText::make($this->type, $value),
            NotionBlockTypeEnum::isSimpleValue($this->type) => NotionSimpleValue::make($this->type, $value),
            NotionBlockTypeEnum::isEmptyValue($this->type) => NotionArrayValue::make($this->type, $value),
        };

    }

}
