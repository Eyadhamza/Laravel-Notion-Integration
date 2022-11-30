<?php

namespace Pi\Notion\Core;

use Pi\Notion\Common\NotionRichText;
use Pi\Notion\NotionClient;

class NotionComment extends NotionObject
{
    private string $discussionId;
    private NotionRichText $content;

    public static function build($response): static
    {
        $comment = parent::build($response);
        $comment->discussionId = $response['discussion_id'];
        $comment->content = NotionRichText::build($response['rich_text']);
        return $comment;
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

        return $this->build($response);
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
