<?php

namespace PISpace\Notion\Traits;

use Illuminate\Support\Collection;
use PISpace\Notion\Core\Properties\BaseNotionProperty;

trait HandleProperties
{
    public function setProperties(array $properties): self
    {
        collect($properties)->map(function (BaseNotionProperty $property) {

            $this->properties->add($property);
        });
        return $this;
    }

    public function buildProperties(array $properties): self
    {
        collect($properties)->map(function (BaseNotionProperty $property) {
            if ($property->shouldBeBuilt()) {
                $property->buildContent();
            }

            $this->properties->add($property);
        });
        return $this;
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }
}
