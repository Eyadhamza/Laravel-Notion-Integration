<?php


namespace Pi\Notion\Traits;


use Illuminate\Support\Facades\Http;

trait RetrieveResource
{


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

}
