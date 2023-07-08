<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionFile;

class NotionPropertyFactory
{

    public static function make(NotionPropertyTypeEnum $propertyType, array $data): BaseNotionProperty
    {
        return match ($propertyType){
            NotionPropertyTypeEnum::TITLE => NotionTitle::fromResponse($data),
            NotionPropertyTypeEnum::RICH_TEXT => NotionText::fromResponse($data),
            NotionPropertyTypeEnum::PHONE_NUMBER => NotionPhoneNumber::fromResponse($data),
            NotionPropertyTypeEnum::MULTISELECT => NotionMultiSelect::fromResponse($data),
            NotionPropertyTypeEnum::SELECT => NotionSelect::fromResponse($data),
            NotionPropertyTypeEnum::EMAIL => NotionEmail::fromResponse($data),
            NotionPropertyTypeEnum::URL => NotionUrl::fromResponse($data),
            NotionPropertyTypeEnum::CHECKBOX => NotionCheckbox::fromResponse($data),
            NotionPropertyTypeEnum::NUMBER => NotionNumber::fromResponse($data),
            NotionPropertyTypeEnum::DATE => NotionDate::fromResponse($data),
            NotionPropertyTypeEnum::PEOPLE => NotionPeople::fromResponse($data),
            NotionPropertyTypeEnum::FILE => NotionFile::build($data),
            NotionPropertyTypeEnum::FORMULA => NotionFormula::fromResponse($data),
            NotionPropertyTypeEnum::RELATION => NotionRelation::fromResponse($data),
            NotionPropertyTypeEnum::ROLLUP => NotionRollup::fromResponse($data),
            NotionPropertyTypeEnum::CREATED_TIME => NotionCreatedTime::fromResponse($data),
            NotionPropertyTypeEnum::LAST_EDITED_TIME => NotionLastEditedTime::fromResponse($data),
            NotionPropertyTypeEnum::CREATED_BY => NotionCreatedBy::fromResponse($data),
            NotionPropertyTypeEnum::LAST_EDITED_BY => NotionLastEditedBy::fromResponse($data),
        };
    }
}
