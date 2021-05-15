<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;

class NotionDatabase extends Workspace
{
    private string $id;

    public function __construct($id = '')
    {
        parent::__construct();

        $this->id = $id;


    }

    public function get($id = null)
    {
        if ($id){
            $this->id = $id;
        }
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get($this->BASE_URL."/databases/{$this->id}");

        $this->throwExceptions($response);

        return $response->json();

    }

    public function throwExceptions($response)
    {
        if ($response->status() == 400){
            throw NotionDatabaseException::notFound($this->id);
        }
        if ($response->status() == 401){
            throw NotionDatabaseException::notAuthorized();
        }
    }
}
