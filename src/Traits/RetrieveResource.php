<?php


namespace Pi\Notion\Traits;


use Illuminate\Support\Facades\Http;

trait RetrieveResource
{

    protected string $URL;
    protected string $id;

    public function get($id = null)
    {
        $id = $id ?? $this->id;

        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->get("$this->URL"."$id");

        $this->throwExceptions($response);


        return $response->json();
    }

    public static function ofId($id)
    {
        return (new self)->get($id);
    }
    # NotionPage::ofId('632b5fb7e06c4404ae12065c48280e4c')
}
