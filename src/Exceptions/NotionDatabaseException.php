<?php


namespace Pi\Notion\Exceptions;



class NotionDatabaseException extends \Exception
{
    public static function badRequest($message = null): static
    {
        return new static("An error occurred, " . $message);
    }
    public static function notAuthorizedToken(): static
    {
        return new static("API token is invalid. you are not authorized to access the notion resource ");
    }
    public static function notAuthorized(): static
    {
        return new static("Given the bearer token used, you don't have permission to perform this operation");
    }
    public static function notFound(): static
    {
        return new static("Given the bearer token used, the resource does not exist. This error can also indicate that the resource has not been shared with you");
    }
    public static function conflictError(): static
    {
        return new static("The transaction could not be completed, potentially due to a data collision. Make sure the parameters are up to date and try again");
    }
    public static function rateLimit(): static
    {
        return new static("Too many requests, This request exceeds the number of requests allowed. Slow down and try again");
    }

    public static function internalServerError(): static
    {
        return new static("An unexpected error occurred. Reach out to Notion support");
    }

    public static function serviceUnavailable(): static
    {
        return new static("Notion is unavailable. Try again later. This can occur when the time to respond to a request takes longer than 60 seconds, the maximum request timeout.");
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
//503	"service_unavailable"	Notion is unavailable. Try again later. This can occur when the time to respond to a request takes longer than 60 seconds, the maximum request timeout.
