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
                throw NotionDatabaseException::notAuthorized();
            }


    }

    //400	"invalid_json"	The request body could not be decoded as JSON.
//400	"invalid_request_url"	The request URL is not valid.
//400	"invalid_request	This request is not supported.
//400	"validation_error"	The request body does not match the schema for the expected parameters. Check the "message" property for more details.
//401	"unauthorized"	The bearer token is not valid.
//403	"restricted_resource"	Given the bearer token used, the client doesn't have permission to perform this operation.
//404	"object_not_found"	Given the bearer token used, the resource does not exist. This error can also indicate that the resource has not been shared with owner of the bearer token.
//409	"conflict_error"	The transaction could not be completed, potentially due to a data collision. Make sure the parameters are up to date and try again.
//429	"rate_limited"	This request exceeds the number of requests allowed. Slow down and try again. More details on rate limits
//500	"internal_server_error"	An unexpected error occurred. Reach out to Notion support.
//503	"service_unavailable"	Notion is unava
}
