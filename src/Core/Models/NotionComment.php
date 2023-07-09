<?php

namespace Pi\Notion\Core\Models;

use Pi\Notion\Core\NotionValue\NotionRichText;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\NotionClient;

class NotionComment extends NotionObject
{
    private string $discussionId;
    private NotionRichText $content;

    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->discussionId = $response['discussion_id'];
        $this->content = NotionRichText::build($response['rich_text']);
        return $this;
    }

    public function create(): self
    {
        $body = [];

        isset($this->discussionId) ? $body['discussion_id'] = $this->discussionId :
            $body['parent'] = [
                'page_id' => $this->parentId
            ];
        $body['rich_text'] = $this->content->getValue();

        $response = NotionClient::request(
            'post',
            NotionClient::COMMENTS_URL,
            $body
        );

        return $this->fromResponse($response);
    }

    public static function findAll(string $blockId, int $pageSize = 100): NotionPaginator
    {
        $comment = new static();
        $comment->paginator = new NotionPaginator();

        $response = $comment
            ->paginator
            ->setUrl($comment->getUrl())
            ->setMethod('get')
            ->setRequestBody(['block_id' => $blockId])
            ->setPageSize($pageSize)
            ->paginate();

        return $comment->paginator->make($response, new NotionComment);
    }

    private function getUrl(): string
    {
        return NotionClient::COMMENTS_URL;
    }

    public function setDiscussionId(string $discussionId): self
    {
        $this->discussionId = $discussionId;
        return $this;
    }

    public function setParentId(string $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function setContent(string|NotionRichText $text): static
    {
        $this->content = is_string($text) ? NotionRichText::make($text) : $text;
        return $this;
    }
}
