<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionFile;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionMedia extends BaseNotionProperty
{

    public ?array $files = [];

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['files'])) {
            return $this;
        }

        $this->value = $response['files'];

        return $this;
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::FILES;

        return $this;
    }

    public function setFiles(?array $files): NotionMedia
    {
        $this->files = collect($files)
            ->map(fn(NotionFile $file) => $file->setBlockType(NotionPropertyTypeEnum::FILE)->resource())
            ->all();

        return $this;
    }

    public function mapToResource(): array
    {
        return $this->files ?? [];
    }
}
