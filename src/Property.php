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
            return [ 'name' => $optionName];
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

    public static function select($name = 'Select', array|string $values = null): Property
    {
        $property =  Property::make(PropertyType::SELECT, $name);

        return $values ? $property->values(['name' => $values]) : $property;

    }

    public static function multiSelect($name = 'MultiSelect', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::MULTISELECT, $name);

        return $values ? $property->multipleValues($values) : $property;

    }

    public static function title($name = 'Name', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::TITLE, $name);

        return $values ? $property->values(['text' => ['content' => $values]]) : $property;

    }

    public static function richText($name = 'RichText', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::RICH_TEXT, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function number($name = 'Number', string $values = null): Property
    {
        $property = Property::make(PropertyType::NUMBER, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function checkbox($name = 'Checkbox', string $values = null): Property
    {
        $property = Property::make(PropertyType::CHECKBOX, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function url($name = 'Url', string $values = null): Property
    {
        $property = Property::make(PropertyType::URL, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function email($name = 'Email', string $values = null): Property
    {
        $property = Property::make(PropertyType::EMAIL, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function phone($name = 'Phone', string $values = null): Property
    {
        $property = Property::make(PropertyType::PHONE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function date($name = 'Date', array $values = null): Property
    {
        $property = Property::make(PropertyType::DATE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function relation($name = 'Relation', string $values = null): Property
    {
        $property = Property::make(PropertyType::RELATION, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function rollup($name = 'Rollup', string $values = null): Property
    {
        $property = Property::make(PropertyType::ROLLUP, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function formula($name = 'Formula', string $values = null): Property
    {
        $property = Property::make(PropertyType::FORMULA, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function file($name = 'File', string $values = null): Property
    {
        $property = Property::make(PropertyType::FILE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function people($name = 'People', string $values = null): Property
    {
        $property = Property::make(PropertyType::PEOPLE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function createdTime($name = 'Created Time', string $values = null): Property
    {
        $property = Property::make(PropertyType::CREATED_TIME, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function lastEditedTime($name = 'Last Edited Time', string $values = null): Property
    {
        $property = Property::make(PropertyType::LAST_EDITED_TIME, $name);

        return $values ? $property->values($values) : $property;
    }
}
