<?php


namespace Pi\Notion\Traits;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;

trait ThrowsExceptions
{
    # TODO i have to change the implementation according to the calling class
    public function throwExceptions($response)
    {

        if (get_class($this) == 'Pi\Notion\NotionDatabase'){
            if ($response->status() == 400){
                throw NotionDatabaseException::notFound($this->id);
            }
            if ($response->status() == 401){
                throw NotionDatabaseException::notAuthorized();
            }
        }

    }
}
