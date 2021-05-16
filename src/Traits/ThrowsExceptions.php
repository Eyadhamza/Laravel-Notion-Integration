<?php


namespace Pi\Notion\Traits;


use Illuminate\Support\Facades\Http;
use Pi\Notion\Exceptions\NotionDatabaseException;

trait ThrowsExceptions
{
    # TODO i have to change the implementation according to the calling class
    public function throwExceptions($response)
    {
        if ($response->status() == 400){
            throw NotionDatabaseException::notFound($response);
        }
        if ($response->status() == 401){
            throw NotionDatabaseException::notAuthorizedToken();
        }

        if ($response->status() == 403){
            throw NotionDatabaseException::notAuthorized();
        }
        if ($response->status() == 404){
            throw NotionDatabaseException::notFound();
        }
        if ($response->status() == 409){
            throw NotionDatabaseException::conflictError();
        }
        if ($response->status() == 429){
            throw NotionDatabaseException::rateLimit();
        }
        if ($response->status() == 500){
            throw NotionDatabaseException::internalServerError();
        }
        if ($response->status() == 503){
            throw NotionDatabaseException::serviceUnavailable();
        }



    }

}
