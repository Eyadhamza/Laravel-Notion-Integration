<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Property;

trait HandleProperties
{
    public function setProperties(Collection|array $properties): self
    {
        $properties = is_array($properties) ? collect($properties) : $properties;

        $properties->map(function ($property) {
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

        $this->properties->add(Property::title($name, $values));
        return $this;
    }
    public function select($name = 'Select', string $values = null): self
    {
        $this->properties->add(Property::select($name, $values));
        return $this;
    }
    public function multiSelect($name = 'MultiSelect', array|string $values = null): self
    {
        $this->properties->add(Property::multiSelect($name, $values));
        return $this;
    }
    public function date($name = 'Date', array|string $values = null): self
    {
        $this->properties->add(Property::date($name, $values));
        return $this;
    }
    public function email($name = 'Email', array|string $values = null): self
    {
        $this->properties->add(Property::email($name, $values));
        return $this;
    }
    public function phone($name = 'Phone', array|string $values = null): self
    {
        $this->properties->add(Property::phone($name, $values));
        return $this;
    }
    public function url($name = 'Url', array|string $values = null): self
    {
        $this->properties->add(Property::url($name, $values));
        return $this;
    }
}
