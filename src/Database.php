<?php


namespace Pi\Notion;


use Illuminate\Support\Facades\Http;

class Database extends Workspace
{
    private string $id;

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;


    }

    public function get()
    {

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get('https://api.notion.com/v1/databases/',[
                'id'=>$this->id
            ])->json();

        dd($response);

    }
}
