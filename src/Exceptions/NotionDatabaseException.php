<?php


namespace Pi\Notion\Exceptions;


use JetBrains\PhpStorm\Pure;

class NotionDatabaseException extends \Exception
{
    #[Pure] public static function notFound($id): static
    {
        return new static("notion database with the id of " . $id . "is not found");
    }
    #[Pure] public static function notAuthorized(): static
    {
        return new static("API token is invalid. you are not authorized to access the notion database with this token ");
    }

}
