<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\Enums\NumberFormatEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;

class NotionNumber extends BaseNotionProperty
{
    private ?int $number = null;
    private ?NumberFormatEnum $format = null;

    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make([
            'number' => $this->number ?? new MissingValue(),
            'format' => $this->format ?? new MissingValue(),
        ])->type('number');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::NUMBER;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['number'])) {
            return $this;
        }
        if (is_int($response['number'])) {
            $this->number = $response['number'];
        }

        $this->format = NumberFormatEnum::tryFrom($response['number']['format'] ?? null);

        return $this;
    }

    public function setNumber(?int $number): NotionNumber
    {
        $this->number = $number;
        return $this;
    }

    public function setFormat(?NumberFormatEnum $format): NotionNumber
    {
        $this->format = $format;
        return $this;
    }


}

