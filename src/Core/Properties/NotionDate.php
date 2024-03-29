<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Content\NotionArrayValue;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasDateFilters;

class NotionDate extends BaseNotionProperty
{
    use HasDateFilters;

    private ?string $timeZone;
    private ?string $end;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::DATE;

        return $this;
    }

    public function setStart(?string $start): NotionDate
    {
        $this->value = $start;

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
            'start' => $this->value ?? new MissingValue(),
            'end' => $this->end ?? new MissingValue(),
            'time_zone' => $this->timeZone ?? new MissingValue(),
        ];
    }
}
