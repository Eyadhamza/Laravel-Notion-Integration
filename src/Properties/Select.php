<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class Select extends Property
{

    public SelectFilter $filter;
    private $optionName;

    private $color;

    private $name;

    private $equals;

    private $notEqual;
    private $isNotEmpty;

    private $isEmpty;

    public function __construct($name , $optionName = null, $color = null,$id=null)
    {
        $this->type = PropertyType::SELECT;

        $this->filter = new SelectFilter;

        parent::__construct($this->type,$id);

        $this->name = $name;
        $this->optionName = $optionName;
        $this->color = $color;


    }

    public function getValues(): array // for page creation
    {
        return
            array(
                'name'=> $this->optionName ?? null,
                'color'=>$this->color ?? null
        );
    }


    public function equals($option): self
    {
         $this->equals = $option;

         return $this;
    }

    public function notEqual($option): self
    {
        $this->notEqual = $option;


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

    /**
     * @return mixed|null
     */
    public function getColor(): mixed
    {
        return $this->color;
    }

    /**
     * @return mixed|null
     */
    public function getOptionName(): mixed
    {
        return $this->optionName;
    }

    /**
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEquals(): mixed
    {
        return $this->equals;
    }

    /**
     * @return mixed
     */
    public function getNotEqual(): mixed
    {
        return $this->notEqual;
    }

    /**
     * @return mixed
     */
    public function getIsNotEmpty(): mixed
    {
        return $this->isNotEmpty;
    }

    /**
     * @return mixed
     */
    public function getIsEmpty(): mixed
    {
        return $this->isEmpty;
    }

    public function getContent()
    {

    }

}
