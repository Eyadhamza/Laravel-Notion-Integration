<?php

namespace Pi\Notion\Common;

class BlockContent
{
    protected string $value;
    private string $type;
    public function __construct($value = '', $type = '')
    {
        $this->value = $value;
        $this->type = $type;
    }

    public function getValue(): string|array
    {
        return $this->value;
    }


    public function getType(): string
    {
        return $this->type;
    }
}
