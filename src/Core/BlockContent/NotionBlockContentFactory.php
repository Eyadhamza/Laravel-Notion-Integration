<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionBlockContentFactory
{

    public static function make(BaseNotionProperty $entity)
    {
        return self::matchFromProperty($entity);
    }

    private static function matchFromProperty(BaseNotionProperty $entity)
    {
        $type = $entity->getType();

        if (self::isRichTextType($type)) {
            return NotionRichText::make($entity->resource->resolve())->setValueType($type);
        }

        if (self::isSimpleValueType($type)) {
            return NotionSimpleValue::make($entity->resource->resolve())->setValueType($type);
        }

        if (self::isArrayValueType($type)) {
            return NotionArrayValue::make($entity->resource->resolve())->setValueType($type);
        }

        return NotionEmptyValue::make()->setValueType($type);
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
