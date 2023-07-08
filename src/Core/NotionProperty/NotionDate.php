<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionObjectValue;

class NotionDate extends BaseNotionProperty
{
    private ?string $start = null;
    private ?string $end = null;
    private ?string $timeZone = null;


    protected function buildValue()
    {
        return NotionObjectValue::make($this->date)->type('date');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::DATE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['date'])){
            return $this;
        }

        $this->start = $response['date']['start'];
        $this->end = $response['date']['end'];
        $this->timeZone = $response['date']['time_zone'];

        return $this;
    }

    public function setDate(string $date): NotionDate
    {
        $this->date = $date;
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

}
