<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{
    private $contains;
    private $notContain;
    private $isNotEmpty;
    private $isEmpty;
    private string $filterSearchOption;
    private string $propertyName;

    public function __construct(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }
    public function setPropertyFilter(): array
    {
        return [
            'property'=> $this->getName(),
            'multi_select'=> $this->setFilterConditions()

        ];

    }
    public function setFilterConditions(): array|null
    {

        if ($this->getContains()){
            return ['contains'=> $this->getContains()];
        }
        if ($this->getNotContain()){
            return ['does_not_contain'=> $this->getNotContain()];
        }
        if ($this->getIsNotEmpty()){
            return ['is_not_empty'=> $this->getIsNotEmpty()];
        }
        if ($this->getContains()){
            return ['is_empty'=> $this->getIsEmpty()];
        }
      return null;
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
        return $this->propertyName;
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
