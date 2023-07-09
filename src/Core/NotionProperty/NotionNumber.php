<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Enums\NotionNumberFormatEnum;

class NotionNumber extends BaseNotionProperty
{
    private ?int $number = null;
    private ?NotionNumberFormatEnum $format = null;

    protected function buildValue(): NotionContent
    {
        if (!$this->number) {
            return NotionArrayValue::make([
                'number' => new MissingValue(),
                'format' => new MissingValue(),
            ])
                ->setValueType($this->type);
        }

        return NotionSimpleValue::make($this->number)
            ->setValueType($this->type);
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

        $this->format = NotionNumberFormatEnum::tryFrom($response['number']['format'] ?? null);

        return $this;
    }

    public function setNumber(?int $number): NotionNumber
    {
        $this->number = $number;
        return $this;
    }

    public function setFormat(?NotionNumberFormatEnum $format): NotionNumber
    {
        $this->format = $format;
        return $this;
    }


}

