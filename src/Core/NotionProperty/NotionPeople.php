<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPeople extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::PEOPLE;

        return $this;
    }

    public function setPeople(?array $people): NotionPeople
    {
        $this->value = collect($people)
            ->map(fn (NotionUser $user) => [
                'object' => $user->objectType ?? 'user',
                'id' => $user->id
            ])
            ->all();

        return $this;
    }

    public function setValue($value): BaseNotionProperty
    {
        $this->value = collect($value)
            ->map(fn(array $data) => NotionUser::make()->fromResponse($data))
            ->all();

        return $this;
    }

    public function mapToResource(): array
    {
        return $this->value ?? [];
    }
}

