<?php


namespace Pi\Notion;


class Database extends Workspace
{
    private string $id;

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;


    }
}
