<?php


namespace Pi\Notion\Properties;


use Illuminate\Support\Collection;
use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class MultiSelect extends Property
{
    private Collection $optionNames;
    private mixed $color;
    private string $name;

    public function __construct($name, $color = null,$id=null)
    {
        parent::__construct(Property::MULTISELECT,$id);
        $this->optionNames = new Collection();
        $this->name = $name;
        $this->color = $color;

    }


    public function addOptions(array $optionNames): self
    {
        $optionNames = collect($optionNames);
        $this->optionNames = $optionNames;
        return $this;

    }

    public function getValues(): Collection
    {

        return
            $this->optionNames->map(function ($optionName){
               return array("name" =>$optionName);
           }
       );
    }
    public function getColor(): mixed
    {
        return $this->color;
    }

    public function getName(): string
    {
        return $this->name;
    }


}
