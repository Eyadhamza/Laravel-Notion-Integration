<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class MultiSelect extends Property
{

    public MultiSelectFilter $filter;

    private mixed $option;
    private mixed $color;
    private string $name;
    private $contains;
    private $notContain;
    private $isNotEmpty;
    private $isEmpty;

    public function __construct($name , $option = null, $color = null,$id=null)
    {
        $this->type = 'multi_select';
        $this->filter = new MultiSelectFilter;

        parent::__construct($this->type,$id);

        $this->name = $name;
        $this->option = $option;
        $this->color = $color;

    }
    public function setPropertyValues($key, $values): array // for page creation
    {

    }


    public function contains($option)
    {
        $this->contains = $option;

        return $this;
    }

    public function notContain($option)
    {
        $this->notContain = $option;


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



    //"Tags": {
    //    "multi_select": [
    //      {
    //        "name": "B"
    //      },
    //      {
    //        "name": "C"
    //      }
    //    ]
    //  }
    /**
     * @return mixed|null
     */
    public function getOption(): mixed
    {
        return $this->option;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|null
     */
    public function getColor(): mixed
    {
        return $this->color;
    }



    /**
     * @return mixed
     */
    public function getIsNotEmpty()
    {
        return $this->isNotEmpty;
    }

    /**
     * @return mixed
     */
    public function getIsEmpty()
    {
        return $this->isEmpty;
    }

    /**
     * @return mixed
     */
    public function getContains()
    {
        return $this->contains;
    }

    /**
     * @return mixed
     */
    public function getNotContain()
    {
        return $this->notContain;
    }

}
