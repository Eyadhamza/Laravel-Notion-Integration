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

    public function __construct($name, $color = null,$id=null)
    {
        $this->type = PropertyType::MULTISELECT;
        $this->filter = new MultiSelectFilter;

        parent::__construct($this->type,$id);

        $this->name = $name;
        $this->color = $color;

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
    public function addOptions(array $optionNames)
    {
        $optionNames = collect($optionNames);

        $this->optionNames = $optionNames;

        return $this;

    }

    public function getValues()
    {

        return
            $this->optionNames->map(function ($optionName){
               return array("name" =>$optionName);
           }
       );
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
