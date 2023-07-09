<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPeople extends BaseNotionProperty
{
    public ?array $people = null;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::PEOPLE;

        return $this;
    }

    public function setPeople(?array $people): NotionPeople
    {
        $this->people = collect($people)
            ->map(fn (NotionUser $user) => [
                'object' => $user->objectType ?? 'user',
                'id' => $user->id
            ])
            ->all();

        return $this;
    }

    public function mapToResource(): array
    {
        return $this->people ?? [];
    }
}

