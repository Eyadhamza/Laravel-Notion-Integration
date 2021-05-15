<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;

class NotionPage extends NotionDatabase
{
    private string $PAGE_URL;
    private string $id;
    public function __construct($id = '')
    {
        parent::__construct();

        $this->id = $id ;
        $this->PAGE_URL = $this->BASE_URL."/pages/";

    }
    public function get($id = null)
    {
        $id = $id ?? $this->id;

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get("$this->PAGE_URL"."$id");

        $this->throwExceptions($response);

        return $response->json();
    }

}
