<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;

class NotionDate extends BaseNotionProperty
{
    private ?string $start = null;
    private ?string $end = null;
    private ?string $timeZone = null;


    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make([
            'start' => $this->start ?? new MissingValue(),
            'end' => $this->end ?? new MissingValue(),
            'time_zone' => $this->timeZone ?? new MissingValue(),
        ])->setType('date');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::DATE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['date'])) {
            return $this;
        }

        $this->start = $response['date']['start'];
        $this->end = $response['date']['end'];
        $this->timeZone = $response['date']['time_zone'];

        return $this;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setStart(?string $start): NotionDate
    {
        $this->start = $start;
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


}
