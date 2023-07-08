<?php

namespace Pi\Notion\Core\Builders;

use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionCreatedBy;
use Pi\Notion\Core\NotionProperty\NotionCreatedTime;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionEmail;
use Pi\Notion\Core\NotionProperty\NotionFormula;
use Pi\Notion\Core\NotionProperty\NotionLastEditedBy;
use Pi\Notion\Core\NotionProperty\NotionLastEditedTime;
use Pi\Notion\Core\NotionProperty\NotionMedia;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use Pi\Notion\Core\NotionProperty\NotionRollup;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\NotionProperty\NotionUrl;

class NotionPropertyBuilder
{

    public static function title(string $name = 'Title')
    {
        return NotionTitle::make($name);
    }

    public static function select(string $name = 'Select')
    {
        return NotionSelect::make($name);
    }

    public static function date(string $name = 'Date')
    {
        return NotionDate::make($name);
    }

    public static function databaseTitle(string $value = 'Untitled Database')
    {
        return NotionDatabaseTitle::make($value, $value);
    }

    public static function formula(string $name)
    {
        return NotionFormula::make($name);
    }

    public static function relation(string $string)
    {
        return NotionRelation::make($string);
    }

    public static function rollup(string $string)
    {
        return NotionRollup::make($string);
    }

    public static function people(string $string)
    {
        return NotionPeople::make($string);
    }

    public static function media(string $string)
    {
        return NotionMedia::make($string);
    }

    public static function checkbox(string $string)
    {
        return NotionCheckbox::make($string);
    }

    public static function email(string $string)
    {
        return NotionEmail::make($string);
    }

    public static function number(string $string)
    {
        return NotionNumber::make($string);
    }

    public static function phone(string $string)
    {
        return NotionPhoneNumber::make($string);
    }

    public static function url(string $string)
    {
        return NotionUrl::make($string);
    }

    public static function createdTime(string $string)
    {
        return NotionCreatedTime::make($string);
    }

    public static function createdBy(string $string)
    {
        return NotionCreatedBy::make($string);
    }

    public static function lastEditedTime(string $string)
    {
        return NotionLastEditedTime::make($string);
    }

    public static function lastEditedBy(string $string)
    {
        return NotionLastEditedBy::make($string);
    }
}
