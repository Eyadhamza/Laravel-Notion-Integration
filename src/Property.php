<?php


namespace Pi\Notion;


class Property extends PropertyType
{

    private string $type;
    private string $name;
    private ?string $id;
    private array|string $values;

    public function __construct(string $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public static function make(string $type, string $name): Property
    {
        return new self($type, $name);
    }

    public function values(array|string $values): self
    {
        $this->values = $values;
        return $this;

    }

    public function getValues(): array|string
    {
        if (is_array($this->values)) {
            return $this->isNested() ? array($this->values) : array($this->values)[0];
        }
        return $this->values;
    }

    public static function addPropertiesToPage($page)
    {

        return $page->getProperties()->mapToAssoc(function ($property) {
            return
                array(
                    $property->name, array($property->getType() => $property->getValues() ?? null)
                );
        });
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function multipleValues(array $values)
    {
        $this->values = collect($values)->map(function ($optionName) {
            return $optionName;
        })->toArray();
        return $this;
    }

    private function isNested(): bool
    {
        return in_array($this->type, [
            self::TITLE,
            self::RICH_TEXT
        ]);
    }

}
