<?php

namespace Pi\Notion\Exceptions;

use Exception;

class NotionException extends Exception
{
    public static function matchException($response)
    {

        match ($response['code'])
        {
            'invalid_json' => throw new InvalidJsonException($response['message'], $response['status']),
            'invalid_request_url' => throw new InvalidRequestUrlException($response['message'], $response['status']),
            'invalid_request' => throw new InvalidRequestException($response['message'], $response['status']),
            'validation_error' => throw new NotionValidationException($response['message'], $response['status']),
            'missing_version' => throw new MissingVersionException($response['message'], $response['status']),
            'unauthorized' => throw new UnauthorizedException($response['message']), $response['status'],
            'restricted_resource' => throw new RestrictedResourceException($response['message'], $response['status']),
            'object_not_found' => throw new ObjectNotFoundException($response['message'], $response['status']),
            'conflict_error' => throw new ConflictErrorException($response['message'], $response['status']),
            'rate_limited' => throw new RateLimitedException($response['message'], $response['status']),
            'internal_server_error' => throw new InternalServerErrorException($response['message'], $response['status']),
            'service_unavailable' => throw new ServiceUnavailableException($response['message'], $response['status']),
        };
    }

}
