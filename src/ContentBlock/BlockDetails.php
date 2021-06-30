<?php


namespace Pi\Notion\ContentBlock;


class BlockDetails
{
    private $heading_1;
    private $heading_2;
    private $heading_3;
    private $bulleted_list_item;
    private $numbered_list_item;
    private $to_do;
    private $toggle;
    private $child_page;

    /**
     * @return mixed
     */
    public function getHeading1()
    {
        return $this->heading_1;
    }

    /**
     * @param mixed $heading_1
     */
    public function setHeading1($heading_1): void
    {
        $this->heading_1 = $heading_1;
    }

    /**
     * @return mixed
     */
    public function getHeading2()
    {
        return $this->heading_2;
    }

    /**
     * @param mixed $heading_2
     */
    public function setHeading2($heading_2): void
    {
        $this->heading_2 = $heading_2;
    }

    /**
     * @return mixed
     */
    public function getHeading3()
    {
        return $this->heading_3;
    }

    /**
     * @param mixed $heading_3
     */
    public function setHeading3($heading_3): void
    {
        $this->heading_3 = $heading_3;
    }

    /**
     * @return mixed
     */
    public function getBulletedListItem()
    {
        return $this->bulleted_list_item;
    }

    /**
     * @param mixed $bulleted_list_item
     */
    public function setBulletedListItem($bulleted_list_item): void
    {
        $this->bulleted_list_item = $bulleted_list_item;
    }

    /**
     * @return mixed
     */
    public function getNumberedListItem()
    {
        return $this->numbered_list_item;
    }

    /**
     * @param mixed $numbered_list_item
     */
    public function setNumberedListItem($numbered_list_item): void
    {
        $this->numbered_list_item = $numbered_list_item;
    }

    /**
     * @return mixed
     */
    public function getToDo()
    {
        return $this->to_do;
    }

    /**
     * @param mixed $to_do
     */
    public function setToDo($to_do): void
    {
        $this->to_do = $to_do;
    }

    /**
     * @return mixed
     */
    public function getToggle()
    {
        return $this->toggle;
    }

    /**
     * @param mixed $toggle
     */
    public function setToggle($toggle): void
    {
        $this->toggle = $toggle;
    }

    /**
     * @return mixed
     */
    public function getChildPage()
    {
        return $this->child_page;
    }

    /**
     * @param mixed $child_page
     */
    public function setChildPage($child_page): void
    {
        $this->child_page = $child_page;
    }


}
