<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionBlockContentFactory
{
    private BaseNotionProperty $entity;
    private NotionPropertyTypeEnum $type;

    public function __construct(BaseNotionProperty $entity)
    {
        $this->entity = $entity;
        $this->type = $entity->getType();

    }

    public static function make(BaseNotionProperty $entity): NotionContent
    {
        return (new self($entity))->matchFromProperty();
    }

    private function matchFromProperty(): NotionContent
    {
        $value = $this->entity->getValue();

        return match (true){
            self::isRichTextType($this->type) => NotionRichText::make($this->type, $value),
            self::isSimpleValueType($this->type) => NotionSimpleValue::make($this->type, $value),
            self::isArrayValueType($this->type) => NotionArrayValue::make($this->type, $value),
            default => NotionEmptyValue::make($this->type, $value)
        };

    }

    private static function isRichTextType(NotionPropertyTypeEnum $type): bool
    {
        return in_array($type, [
            NotionPropertyTypeEnum::RICH_TEXT,
            NotionPropertyTypeEnum::TITLE,
            NotionPropertyTypeEnum::DESCRIPTION
        ]);
    }

    private static function isSimpleValueType(NotionPropertyTypeEnum $type): bool
    {
        return in_array($type, [
            NotionPropertyTypeEnum::EMAIL,
            NotionPropertyTypeEnum::CHECKBOX,
            NotionPropertyTypeEnum::URL,
            NotionPropertyTypeEnum::PHONE_NUMBER,
        ]);
    }

    private static function isArrayValueType(NotionPropertyTypeEnum $type): bool
    {
        return in_array($type, [
            NotionPropertyTypeEnum::MULTISELECT,
            NotionPropertyTypeEnum::RELATION,
            NotionPropertyTypeEnum::PEOPLE,
            NotionPropertyTypeEnum::FILES,
            NotionPropertyTypeEnum::SELECT,
            NotionPropertyTypeEnum::DATE,
            NotionPropertyTypeEnum::FORMULA,
            NotionPropertyTypeEnum::ROLLUP,
        ]);
    }

}
