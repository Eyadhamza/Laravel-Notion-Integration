<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Content\NotionArrayValue;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionFile;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
