<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\RetrieveResource;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionPage extends Workspace
{
    use RetrieveResource;
    use ThrowsExceptions;

    private string $type;
    private string $id;
    private string $URL;
    private mixed $created_time;
    private mixed $last_edited_time;
    private Collection $blocks;
    private Collection $properties;
    private mixed $archived;


    public function __construct($id = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->URL = Workspace::PAGE_URL;
        $this->type = 'page';
        $this->blocks = new Collection();
        $this->properties = new Collection();

    }

    public function create($notionDatabaseId): self
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->withHeaders(['Notion-Version' => Workspace::NOTION_VERSION])
            ->post($this->URL, [
                'parent' => array('database_id' => $notionDatabaseId),
                'properties' => Property::addPropertiesToPage($this),
                'children' => Block::addBlocksToPage($this)
            ]);
        return $this;
    }

    public function addBlocks(Collection $blocks): self
    {

        $blocks->map(function ($block) {
            $this->blocks->add($block);
        });

        return $this;
    }

    public function setProperties(Collection|array $properties): self
    {
        $properties = is_array($properties) ? collect($properties) : $properties;

        $properties->map(function ($property) {
            $this->properties->add($property);
        });
        return $this;
    }

    public function search($pageTitle, $sortDirection = 'ascending', $timestamp = 'last_edited_time')
    {
        $response = Http::withToken(config('notion-wrapper.info.token'))->post(Workspace::SEARCH_PAGE_URL, ['query' => $pageTitle,
            'sort' => [
                'direction' => $sortDirection,
                'timestamp' => $timestamp
            ]]);
//        $this->constructPageObject($response->json()); TODO
        return $response->json();

    }

    public function update()
    {
        //TODO
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function setBlocks(Collection $blocks): void
    {
        $this->blocks = $blocks;
    }

    public function constructObject(mixed $json): self
    {
        $this->type = 'page';
        $this->id = $json['id'];
        $this->created_time = $json['created_time'];
        $this->last_edited_time = $json['last_edited_time'];
        $this->archived = $json['archived'];
        return $this;

    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public static function setSelect($name = 'Select', array|string $values = null): Property
    {
        $property =  Property::make(PropertyType::SELECT, $name);

        return $values ? $property->values($values) : $property;

    }

    public static function setMultiSelect($name = 'MultiSelect', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::MULTISELECT, $name);

        return $values ? $property->values($values) : $property;

    }

    public static function setTitle($name = 'Name', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::TITLE, $name);

        return $values ? $property->values(['text' => ['content' => $values]]) : $property;

    }

    public static function setRichText($name = 'RichText', array|string $values = null): Property
    {
        $property = Property::make(PropertyType::RICH_TEXT, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setNumber($name = 'Number', string $values = null): Property
    {
        $property = Property::make(PropertyType::NUMBER, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setCheckbox($name = 'Checkbox', string $values = null): Property
    {
        $property = Property::make(PropertyType::CHECKBOX, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setUrl($name = 'Url', string $values = null): Property
    {
        $property = Property::make(PropertyType::URL, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setEmail($name = 'Email', string $values = null): Property
    {
        $property = Property::make(PropertyType::EMAIL, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setPhone($name = 'Phone', string $values = null): Property
    {
        $property = Property::make(PropertyType::PHONE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setDate($name = 'Date', array $values = null): Property
    {
        $property = Property::make(PropertyType::DATE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setRelation($name = 'Relation', string $values = null): Property
    {
        $property = Property::make(PropertyType::RELATION, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setRollup($name = 'Rollup', string $values = null): Property
    {
        $property = Property::make(PropertyType::ROLLUP, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setFormula($name = 'Formula', string $values = null): Property
    {
        $property = Property::make(PropertyType::FORMULA, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setFile($name = 'File', string $values = null): Property
    {
        $property = Property::make(PropertyType::FILE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setPeople($name = 'People', string $values = null): Property
    {
        $property = Property::make(PropertyType::PEOPLE, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setCreatedTime($name = 'Created Time', string $values = null): Property
    {
        $property = Property::make(PropertyType::CREATED_TIME, $name);

        return $values ? $property->values($values) : $property;
    }

    public static function setLastEditedTime($name = 'Last Edited Time', string $values = null): Property
    {
        $property = Property::make(PropertyType::LAST_EDITED_TIME, $name);

        return $values ? $property->values($values) : $property;
    }

}
