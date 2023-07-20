<?php

namespace Pi\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Content\NotionArrayValue;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionRollup extends BaseNotionProperty
{
    public ?string $rollupType;
    public ?int $rollupNumber = null;
    private ?string $relationPropertyName = null;
    private ?string $relationPropertyId = null;
    private ?string $rollupPropertyName = null;
    private ?string $rollupPropertyId = null;
    private ?string $rollupFunction = null;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::ROLLUP;

        return $this;
    }


    public function setRelationPropertyName(?string $relationPropertyName): NotionRollup
    {
        $this->relationPropertyName = $relationPropertyName;
        return $this;
    }

    public function setRelationPropertyId(?string $relationPropertyId): NotionRollup
    {
        $this->relationPropertyId = $relationPropertyId;
        return $this;
    }

    public function setRollupPropertyName(?string $rollupPropertyName): NotionRollup
    {
        $this->rollupPropertyName = $rollupPropertyName;
        return $this;
    }

    public function setRollupPropertyId(?string $rollupPropertyId): NotionRollup
    {
        $this->rollupPropertyId = $rollupPropertyId;
        return $this;
    }

    public function setFunction(?string $function): NotionRollup
    {
        $this->rollupFunction = $function;
        return $this;
    }


    public function mapToResource(): array
    {
        return [
            'rollup_property_name' => $this->rollupPropertyName,
            'rollup_property_id' => $this->rollupPropertyId ?? new MissingValue(),
            'relation_property_name' => $this->relationPropertyName,
            'relation_property_id' => $this->relationPropertyId ?? new MissingValue(),
            'function' => $this->rollupFunction,
        ];
    }
}

