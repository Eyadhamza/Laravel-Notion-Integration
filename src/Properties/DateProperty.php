<?php


namespace Pi\Notion\Properties;


class DateProperty extends Property
{
    private string $start;
    private ?string $end;
    public function __construct(string $type, string $name, string $start, string $end = null, string $id = null)
    {
        parent::__construct($type, $name, $id);
        $this->start = $start;
        $this->end = $end;

    }

    public function getValues(): array
    {
        return
            array(
                'start' => $this->start,
                'end' => $this->end ?? null
        );
    }

}
