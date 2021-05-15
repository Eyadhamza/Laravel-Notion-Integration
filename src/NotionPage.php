<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\RetrieveResource;

class NotionPage extends NotionDatabase
{
    use RetrieveResource;

    public function __construct($id = '')
    {
        parent::__construct();

        $this->id = $id ;
        $this->URL = $this->BASE_URL."/pages/";

    }


}
