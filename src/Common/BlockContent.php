<?php

namespace Pi\Notion\Common;

class BlockContent
{
    protected string|array $value;
    protected string $type;
    public function __construct($value = '', $type = '')
    {
        $this->value = $value;
        $this->type = $type;
    }
    public static function build(array $response): static
    {
        $blockContent = new static();
        $blockContent->type = $response[0]['type'];
        return $blockContent;
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
