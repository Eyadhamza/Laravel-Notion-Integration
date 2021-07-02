<?php


namespace Pi\Notion\Properties;


use Illuminate\Support\Collection;
use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class MultiSelect extends Property
{

    public MultiSelectFilter $filter;

    private Collection $optionNames;
    private mixed $color;
    private string $name;
    private $contains;
    private $notContain;
    private $isNotEmpty;
    private $isEmpty;
    private string $filterSearchOption;
    public function __construct($name, $color = null,$id=null)
    {
        $this->type = PropertyType::MULTISELECT;
        $this->filter = new MultiSelectFilter;
        parent::__construct($this->type,$id);
        $this->optionNames = new Collection();
        $this->name = $name;
        $this->color = $color;
        $this->filterSearchOption = '';
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

    public function contains($filterSearchName)
    {
        $this->contains = $filterSearchName;

        return $this;
    }

    public function notContain($filterSearchName)
    {
        $this->notContain = $filterSearchName;
        return $this;
    }

    public function isNotEmpty()
    {
        $this->isNotEmpty = true;
        return $this;
    }

    public function isEmpty()
    {
        $this->isEmpty = true;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getColor(): mixed
    {
        return $this->color;
    }

    public function getIsNotEmpty()
    {
        return $this->isNotEmpty;
    }

    public function getIsEmpty()
    {
        return $this->isEmpty;
    }

    public function getContains()
    {
        return $this->contains;
    }

    public function getNotContain()
    {
        return $this->notContain;
    }

    public function getFilterSearchOption(): string
    {
        return $this->filterSearchOption;
    }

    public function setFilterSearchOption(string $filterSearchOption): void
    {
        $this->filterSearchOption = $filterSearchOption;
    }


}
