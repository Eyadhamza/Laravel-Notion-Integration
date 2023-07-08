<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionFile;

class NotionPropertyFactory
{

    public static function make(NotionPropertyTypeEnum $propertyType, array $data): BaseNotionProperty
    {
        return match ($propertyType){
            NotionPropertyTypeEnum::TITLE => NotionTitle::build($data),
            NotionPropertyTypeEnum::RICH_TEXT => NotionText::build($data),
            NotionPropertyTypeEnum::PHONE_NUMBER => NotionPhoneNumber::build($data),
            NotionPropertyTypeEnum::MULTISELECT => NotionMultiSelect::build($data),
            NotionPropertyTypeEnum::SELECT => NotionSelect::build($data),
            NotionPropertyTypeEnum::EMAIL => NotionEmail::build($data),
            NotionPropertyTypeEnum::URL => NotionUrl::build($data),
            NotionPropertyTypeEnum::CHECKBOX => NotionCheckbox::build($data),
            NotionPropertyTypeEnum::NUMBER => NotionNumber::build($data),
            NotionPropertyTypeEnum::DATE => NotionDate::build($data),
            NotionPropertyTypeEnum::PEOPLE => NotionPeople::build($data),
            NotionPropertyTypeEnum::FILE => NotionFile::build($data),
            NotionPropertyTypeEnum::FORMULA => NotionFormula::build($data),
            NotionPropertyTypeEnum::RELATION => NotionRelation::build($data),
            NotionPropertyTypeEnum::ROLLUP => NotionRollup::build($data),
            NotionPropertyTypeEnum::CREATED_TIME => NotionCreatedTime::build($data),
            NotionPropertyTypeEnum::LAST_EDITED_TIME => NotionLastEditedTime::build($data),
            NotionPropertyTypeEnum::CREATED_BY => NotionCreatedBy::build($data),
            NotionPropertyTypeEnum::LAST_EDITED_BY => NotionLastEditedBy::build($data),

        };
    }
}
