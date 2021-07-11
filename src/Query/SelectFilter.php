<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;
use Pi\Notion\Properties\Select;

class SelectFilter implements Filterable
{
    private string $equals;
    private ?string $notEqual;
    private ?bool $isNotEmpty;
    private ?bool $isEmpty;
    private ?string $propertyName;

    public function __construct(string $propertyName, string $equals = null, string $notEqual  = null, bool $isNotEmpty  = null, bool $isEmpty  = null)
    {
        $this->propertyName = $propertyName;
        $this->equals = $equals ?? '';
        $this->notEqual = $notEqual ?? '';
        $this->isNotEmpty = $isNotEmpty ?? true;
        $this->isEmpty = $isEmpty ?? false;
    }

    public function setPropertyFilter(): array
    {

       return array(
           'property'=> $this->propertyName,
           'select'=>  $this->setFilterConditions()
       );

    }

    public function setFilterConditions(): array|null
    {

        if ($this->equals){
            return ['equals'=> $this->equals];
        }
        if ($this->notEqual){
            return ['does_not_equal'=> $this->notEqual];
        }
        if ($this->isNotEmpty){
            return ['is_not_empty'=> $this->isNotEmpty];
        }
        if ($this->isEmpty){
            return ['is_empty'=> $this->isEmpty];
        }
        return ['equals'=> $this->equals];

    }
    public function equals($optionName): self
    {
        $this->equals = $optionName;
        return $this;
    }

    public function notEqual($optionName): self
    {
        $this->notEqual = $optionName;
        return $this;
    }
    public function isNotEmpty(): self
    {
        $this->isNotEmpty = true;
        return $this;
    }

    public function isEmpty(): self
    {
        $this->isEmpty = true;
        return $this;
    }

    public function getColor(): mixed
    {
        return $this->color;
    }

    public function getOptionName(): mixed
    {
        return $this->optionName;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getEquals(): mixed
    {
        return $this->equals;
    }

    public function getNotEqual(): mixed
    {
        return $this->notEqual;
    }

    public function getIsNotEmpty(): mixed
    {
        return $this->isNotEmpty;
    }

    public function getIsEmpty(): mixed
    {
        return $this->isEmpty;
    }
}
