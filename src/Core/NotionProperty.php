<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use Pi\Notion\PropertyType;
use stdClass;

class NotionProperty
{

    private string $type;
    private string $name;
    private ?string $id;
    private array|string|null $values;
    private array|string|null $options;

    public function __construct(string $type, string $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    public static function make(string $type, string $name): NotionProperty
    {
        return new self($type, $name);
    }

    public function setValues(array|string $values): self
    {
        $this->values = $values;
        return $this;

    }

    public function getValues(): array|string
    {
        if (!isset($this->values)) {
            return [];
        }
        if (is_array($this->values)) {
            return $this->isNested() ? array($this->values) : array($this->values)[0];
        }
        return $this->values;
    }

    public static function mapsProperties($page)
    {
        return $page->getProperties()->mapToAssoc(function (NotionProperty $property) {
            return
                array(
                    $property->name, array($property->getType() => empty($property->getValues()) ? $property->getOptions() : $property->getValues())
                );
        });
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function buildProperty(string $name, array $body): NotionProperty
    {

        $property = NotionProperty::make($body['type'], $name);
        $property->id = $body['id'];

        $property->options = $body[$body['type']]['options'] ?? [];
        return $property;
    }

    public static function buildList(mixed $response)
    {
        $list = new Collection();
        collect($response['results'])->each(function ($item) use ($list) {
            $list->add(self::buildProperty($item['type'], $item));
        });
        return $list;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function multipleValues(array $values)
    {

        $this->values = collect($values)->map(function ($optionName) {
            return ['name' => $optionName];
        })->toArray();
        return $this;
    }

    public function getOptions()
    {
        if (!isset($this->options)) {
            return new stdClass();
        }
        if (is_array($this->options)) {
            return [
                'options' => $this->options
            ];
        }
        return array($this->options);
    }
    public function setOptions(array|string $options): self
    {
        $this->options = $options;
        return $this;
    }

    private function isNested(): bool
    {
        return in_array($this->type, [
            PropertyType::TITLE,
            PropertyType::RICH_TEXT
        ]);
    }

    public static function select($name = 'Select', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::SELECT, $name);

        return $values ? $property->setValues(['name' => $values]) : $property;

    }

    public static function multiSelect($name = 'MultiSelect', array|string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::MULTISELECT, $name);

        return $values ? $property->multipleValues($values) : $property;

    }

    public static function title($name = 'Name', array|string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::TITLE, $name);

        return $values ? $property->setValues(['text' => ['content' => $values]]) : $property;

    }

    public static function richText($name = 'NotionRichText', array|string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::RICH_TEXT, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function number($name = 'Number', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::NUMBER, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function checkbox($name = 'Checkbox', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::CHECKBOX, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function url($name = 'Url', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::URL, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function email($name = 'Email', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::EMAIL, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function phone($name = 'Phone', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::PHONE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function date($name = 'Date', array $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::DATE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function relation($name = 'Relation', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::RELATION, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function rollup($name = 'Rollup', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::ROLLUP, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function formula($name = 'Formula', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::FORMULA, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function file($name = 'File', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::FILE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function people($name = 'People', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::PEOPLE, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function createdTime($name = 'Created Time', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::CREATED_TIME, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public static function lastEditedTime($name = 'Last Edited Time', string $values = null): NotionProperty
    {
        $property = NotionProperty::make(PropertyType::LAST_EDITED_TIME, $name);

        return $values ? $property->setValues($values) : $property;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function ofName(string $name): bool
    {
        return $this->name == $name;
    }

    public function isPaginated(): bool
    {
        return in_array($this->type, [
            PropertyType::TITLE,
            PropertyType::RICH_TEXT,
            PropertyType::RELATION,
            PropertyType::PEOPLE,
        ]);
    }
}
