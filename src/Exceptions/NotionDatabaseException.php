<?php


namespace Pi\Notion\Exceptions;


class NotionDatabaseException extends \Exception
{
    public static function notFound($id): static
    {
        return new static("notion database with the id of " . $id . "is not found");
    }

}
