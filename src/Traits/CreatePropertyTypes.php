<?php

namespace Pi\Notion\Traits;

use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\PropertyType;

trait CreatePropertyTypes
{

    public static function select($name = 'Select', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::SELECT, $name);

        return $values ? $property->setValues(['name' => $values]) : $property;

    }

    public static function multiSelect($name = 'MultiSelect', array|string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::MULTISELECT, $name);

        return $values ? $property->setMultipleValues($values) : $property;

    }

    public static function title($name = 'Name', array|string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::TITLE, $name);

        return $values ? $property->setValues($values) : $property;

    }

    public static function richText($name = 'NotionRichText', array|string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::RICH_TEXT, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function number($name = 'Number', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::NUMBER, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function checkbox($name = 'Checkbox', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::CHECKBOX, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function url($name = 'Url', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::URL, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function email($name = 'Email', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::EMAIL, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function phone($name = 'Phone', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::PHONE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function date($name = 'Date', array $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::DATE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function relation($name = 'Relation', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::RELATION, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function rollup($name = 'Rollup', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::ROLLUP, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function formula($name = 'Formula', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::FORMULA, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function file($name = 'File', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::FILE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function people($name = 'People', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::PEOPLE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function createdTime($name = 'Created Time', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::CREATED_TIME, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function lastEditedTime($name = 'Last Edited Time', string $values = null): BaseNotionProperty
    {
        $property = BaseNotionProperty::make(PropertyType::LAST_EDITED_TIME, $name);

        return $values ? $property->setValues($values) : $property;
    }
}
