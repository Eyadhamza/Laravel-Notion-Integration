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
        $id='632b5fb7e06c4404ae12065c48280e4c';
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get($this->BASE_URL."/databases/{$id}")->json();

        dd($response);

    }
}
