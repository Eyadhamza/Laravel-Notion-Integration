<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDate extends BaseNotionProperty
{
    private ?string $timeZone;
    private ?string $end;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::DATE;

        return $this;
    }

    public function setStart(?string $start): NotionDate
    {
        $this->rawValue = $start;

        return $this;
    }

    public function setEnd(?string $end): NotionDate
    {
        $this->end = $end;

        return $this;
    }

    public function setTimeZone(?string $timeZone): NotionDate
    {
        $this->timeZone = $timeZone;

        return $this;
    }
    public function mapToResource(): array
    {
        return [
            'start' => $this->rawValue ?? new MissingValue(),
            'end' => $this->end ?? new MissingValue(),
            'time_zone' => $this->timeZone ?? new MissingValue(),
        ];
    }
}
