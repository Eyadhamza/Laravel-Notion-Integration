<?php

namespace Pi\Notion\Core\Builders;

use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionCreatedBy;
use Pi\Notion\Core\NotionProperty\NotionCreatedTime;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionEmail;
use Pi\Notion\Core\NotionProperty\NotionFiles;
use Pi\Notion\Core\NotionProperty\NotionFormula;
use Pi\Notion\Core\NotionProperty\NotionLastEditedBy;
use Pi\Notion\Core\NotionProperty\NotionLastEditedTime;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use Pi\Notion\Core\NotionProperty\NotionRollup;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\NotionProperty\NotionUrl;
use Pi\Notion\Core\BlockContent\NotionFormulaValue;

class NotionPropertyBuilder
{

    public static function title(string $name = 'Title')
    {
        return NotionTitle::make($name);
    }

    public static function select(string $name = 'Select', array $options = []): NotionSelect
    {
        return NotionSelect::make($name, $options);
    }

    public static function date(string $name = 'Date')
    {
        return NotionDate::make($name);
    }

    public static function databaseTitle(string $value = 'Untitled Database')
    {
        return NotionTitle::make($value, $value);
    }

    public static function formula(string $name, NotionFormulaValue $formulaValue = null)
    {
        return NotionFormula::make($name, $formulaValue);
    }

    public static function buildFormula(string $name, string $expression = null)
    {
        return NotionFormula::make($name, $expression);
    }

    public static function relation(string $name,)
    {
        return NotionRelation::make($name,);
    }

    public static function buildRelation(string $name)
    {
        return NotionRelation::make($name);
    }
    public static function rollup(string $name,)
    {
        return NotionRollup::make($name,);
    }

    public static function people(string $name,)
    {
        return NotionPeople::make($name,);
    }

    public static function media(string $name,)
    {
        return NotionFiles::make($name,);
    }

    public static function checkbox(string $name, bool $checked = false)
    {
        return NotionCheckbox::make($name, $checked);
    }

    public static function email(string $name,)
    {
        return NotionEmail::make($name,);
    }

    public static function number(string $name,)
    {
        return NotionNumber::make($name,);
    }

    public static function phone(string $name,)
    {
        return NotionPhoneNumber::make($name,);
    }

    public static function url(string $name,)
    {
        return NotionUrl::make($name,);
    }

    public static function createdTime(string $name,)
    {
        return NotionCreatedTime::make($name,);
    }

    public static function createdBy(string $name,)
    {
        return NotionCreatedBy::make($name,);
    }

    public static function lastEditedTime(string $name,)
    {
        return NotionLastEditedTime::make($name,);
    }

    public static function lastEditedBy(string $name,)
    {
        return NotionLastEditedBy::make($name,);
    }

}
