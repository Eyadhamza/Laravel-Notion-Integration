<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Content\NotionFile;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionPropertyFactory
{

    public static function make(NotionPropertyTypeEnum $propertyType, string $propertyName): BaseNotionProperty
    {
        return match ($propertyType){
            NotionPropertyTypeEnum::TITLE => NotionTitle::make($propertyName),
            NotionPropertyTypeEnum::RICH_TEXT => NotionText::make($propertyName),
            NotionPropertyTypeEnum::PHONE_NUMBER => NotionPhoneNumber::make($propertyName),
            NotionPropertyTypeEnum::MULTISELECT => NotionMultiSelect::make($propertyName),
            NotionPropertyTypeEnum::SELECT => NotionSelect::make($propertyName),
            NotionPropertyTypeEnum::EMAIL => NotionEmail::make($propertyName),
            NotionPropertyTypeEnum::URL => NotionUrl::make($propertyName),
            NotionPropertyTypeEnum::CHECKBOX => NotionCheckbox::make($propertyName),
            NotionPropertyTypeEnum::NUMBER => NotionNumber::make($propertyName),
            NotionPropertyTypeEnum::DATE => NotionDate::make($propertyName),
            NotionPropertyTypeEnum::PEOPLE => NotionPeople::make($propertyName),
            NotionPropertyTypeEnum::FILE => NotionFile::make($propertyName),
            NotionPropertyTypeEnum::FORMULA => NotionFormula::make($propertyName),
            NotionPropertyTypeEnum::RELATION => NotionRelation::make($propertyName),
            NotionPropertyTypeEnum::ROLLUP => NotionRollup::make($propertyName),
            NotionPropertyTypeEnum::CREATED_TIME => NotionCreatedTime::make($propertyName),
            NotionPropertyTypeEnum::LAST_EDITED_TIME => NotionLastEditedTime::make($propertyName),
            NotionPropertyTypeEnum::CREATED_BY => NotionCreatedBy::make($propertyName),
            NotionPropertyTypeEnum::LAST_EDITED_BY => NotionLastEditedBy::make($propertyName),
            NotionPropertyTypeEnum::FILES => NotionMedia::make($propertyName),
            NotionPropertyTypeEnum::DESCRIPTION => NotionDatabaseDescription::make($propertyName),

        };
    }
}
