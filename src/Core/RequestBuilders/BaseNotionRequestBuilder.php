<?php

namespace Pi\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;

abstract class BaseNotionRequestBuilder
{
    abstract public function toArray();
}
