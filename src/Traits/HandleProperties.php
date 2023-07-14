<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;

trait HandleProperties
{
    public function setProperties(array $properties): self
    {
        collect($properties)->map(function (BaseNotionProperty $property) {
            $this->properties->add($property->buildContent());
        });
        return $this;
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }
}
