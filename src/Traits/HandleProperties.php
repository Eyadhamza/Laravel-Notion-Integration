<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty;

trait HandleProperties
{
    public function createProperties(array $properties): self
    {

        collect($properties)->map(function (NotionProperty $property) {
            $this->properties->add([
                $property->getName() => [
                    $property->getType() => $property->getOptions()
                ]
            ]);
        });
        return $this;
    }
    public function setProperties(array $properties): self
    {
        collect($properties)->map(function ($property) {
            $this->properties->add($property);
        });
        return $this;
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function title($name = 'Name', string $values = null): self
    {
        $this->properties->add(NotionProperty::title($name, $values));
        return $this;
    }
    public function select($name = 'Select', string $values = null): self
    {
        $this->properties->add(NotionProperty::select($name, $values));
        return $this;
    }
    public function multiSelect($name = 'MultiSelect', array|string $values = null): self
    {
        $this->properties->add(NotionProperty::multiSelect($name, $values));
        return $this;
    }
    public function date($name = 'Date', array|string $values = null): self
    {
        $this->properties->add(NotionProperty::date($name, $values));
        return $this;
    }
    public function email($name = 'Email', array|string $values = null): self
    {
        $this->properties->add(NotionProperty::email($name, $values));
        return $this;
    }
    public function phone($name = 'Phone', array|string $values = null): self
    {
        $this->properties->add(NotionProperty::phone($name, $values));
        return $this;
    }
    public function url($name = 'Url', array|string $values = null): self
    {
        $this->properties->add(NotionProperty::url($name, $values));
        return $this;
    }
}
