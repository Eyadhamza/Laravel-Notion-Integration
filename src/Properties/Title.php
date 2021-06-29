<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class Title extends Property
{



    private $name;
    private $option;


    public function __construct($name , $option = null, $color = null,$id=null)
    {
        $this->type = 'title';

        parent::__construct($this->type,$id);

        $this->name = $name;

        $this->option = $option;


    }

    public function setPropertyValues($name, $types): array // for page creation
    {

    }



    public function getName()
    {
        return $this->name;
    }

    public function values(): array // for page creation
    {
        return
            array(
                    array(
                        'text' => array('content' => $this->getOption())
                    ) ?? null
        );
    }

    public function getContent()
    {

    }

    /**
     * @return mixed|null
     */
    public function getOption(): mixed
    {
        return $this->option;
    }

    // $property->getType() =='title' ?
    //                                array(
    //                                    $property->getType() =>array(
    //                                        array(
    //                                        'text' => array('content' => $property->getOption()) ?? null,
    //
    //                                    )
    //                                )
    //                            ) :
}
