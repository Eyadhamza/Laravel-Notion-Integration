<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\Enums\NumberFormatEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionSimpleValue;

class NotionNumber extends BaseNotionProperty
{
    private ?int $number = null;
    private ?NumberFormatEnum $format = null;

    protected function buildValue(): NotionBlockContent
    {
        if (!$this->number) {
            return NotionArrayValue::make([
                'number' => new MissingValue(),
                'format' => new MissingValue(),
            ])
                ->setType($this->type->value);
        }

        return NotionSimpleValue::make($this->number)
            ->setType($this->type->value);
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

