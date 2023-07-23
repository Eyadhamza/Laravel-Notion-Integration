<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Models\NotionUser;
use PISpace\Notion\Core\Content\NotionArrayValue;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
                'object' => 'user',
                'id' => $user->getId()
            ])
            ->all();

        return $this;
    }

    public function setValue($value): BaseNotionProperty
    {
        $this->value = collect($value)
            ->map(function (NotionUser|array $item) {
                if ($item instanceof NotionUser) {
                    return [
                        'object' => 'user',
                        'id' => $item->getId()
                    ];
                }

                return NotionUser::make()->fromResponse($item);
            })
            ->all();

        return $this;
    }

}

