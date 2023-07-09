<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionBlockContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPeople extends BaseNotionProperty
{
    private ?array $people = null;

    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make($this->people ?? new MissingValue())
            ->setValueType($this->type);
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['people'])) {
            return $this;
        }

        $this->people = $response['people'];

        return $this;
    }

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

}

