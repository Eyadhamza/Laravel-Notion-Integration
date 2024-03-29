<?php

namespace PISpace\Notion\Core\RequestBuilders;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Content\NotionRichText;

class CreateNotionCommentRequestBuilder extends BaseNotionRequestBuilder
{

    private ?NotionRichText $text = null;
    private ?string $discussionId = null;
    private ?string $parent = null;

    public static function make()
    {
        return new static();
    }

    public function toArray(): array
    {
        return array_merge($this->getParentIfSet(), $this->text->resource(), [
            'discussion_id' => $this->discussionId ?? new MissingValue(),
        ]);
    }

    public function setDiscussionId(?string $discussionId): static
    {
        $this->discussionId = $discussionId;
        return $this;
    }

    public function setParentId(?string $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function setContent(NotionRichText $content): self
    {
        $this->text = $content;
        return $this;
    }

    private function getParentIfSet(): array
    {
        if (!$this->parent) {
            return [];
        }
        return [
            'parent' => [
                'page_id' => $this->parent,
            ],
        ];
    }
}
