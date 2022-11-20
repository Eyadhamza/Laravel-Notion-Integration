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
    public static function setSelect($name = 'Select'): self
    {
        return Property::make(PropertyType::SELECT, $name);
    }
    public static function setMultiSelect($name = 'MultiSelect'): self
    {
        return Property::make(PropertyType::MULTISELECT, $name);
    }
    public static function setTitle($name = 'Name'): self
    {
        return Property::make(PropertyType::TITLE, $name);
    }
    public static function setRichText($name = 'RichText'): self
    {
        return Property::make(PropertyType::RICH_TEXT, $name);
    }
    public static function setNumber($name = 'Number'): self
    {
        return Property::make(PropertyType::NUMBER, $name);
    }
    public static function setCheckbox($name = 'Checkbox'): self
    {
        return Property::make(PropertyType::CHECKBOX, $name);
    }
    public static function setUrl($name = 'Url'): self
    {
        return Property::make(PropertyType::URL, $name);
    }
    public static function setEmail($name = 'Email'): self
    {
        return Property::make(PropertyType::EMAIL, $name);
    }
    public static function setPhone($name = 'Phone'): self
    {
        return Property::make(PropertyType::PHONE, $name);
    }
    public static function setDate($name = 'Date'): self
    {
        return Property::make(PropertyType::DATE, $name);
    }
    public static function setRelation($name = 'Relation'): self
    {
        return Property::make(PropertyType::RELATION, $name);
    }
    public static function setRollup($name = 'Rollup'): self
    {
        return Property::make(PropertyType::ROLLUP, $name);
    }
    public static function setFormula($name = 'Formula'): self
    {
        return Property::make(PropertyType::FORMULA, $name);
    }
    public static function setFile($name = 'File'): self
    {
        return Property::make(PropertyType::FILE, $name);
    }
    public static function setPeople($name = 'People'): self
    {
        return Property::make(PropertyType::PEOPLE, $name);
    }
    public static function setCreatedBy($name = 'Created By'): self
    {
        return Property::make(PropertyType::CREATED_BY, $name);
    }
    public static function setLastEditedBy($name = 'Last Edited By'): self
    {
        return Property::make(PropertyType::LAST_EDITED_BY, $name);
    }
    public static function setCreatedTime($name = 'Created Time'): self
    {
        return Property::make(PropertyType::CREATED_TIME, $name);
    }
    public static function setLastEditedTime($name = 'Last Edited Time'): self
    {
        return Property::make(PropertyType::LAST_EDITED_TIME, $name);
    }

}
