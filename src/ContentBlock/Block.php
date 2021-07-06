<?php


namespace Pi\Notion\ContentBlock;


use Illuminate\Support\Collection;
use Pi\Notion\NotionPage;

class Block
{
    private ?string $object;
    private ?string $id;
    private ?string $created_time;
    private ?string $last_edited_time;
    private ?bool $has_children;
    private ?string $type;
    private ?string $body;
    private  $content;
    private ?NotionPage $notionPage;
    private $contentType;


    public function __construct($type = null,$body = null, $id= null, $contentType = null, $created_time= null, $last_edited_time= null, $has_children= null)
    {
        $this->object = 'block';
        $this->id = $id;
        $this->created_time = $created_time;
        $this->last_edited_time = $last_edited_time;
        $this->has_children = $has_children;
        $this->type = $type;
        $this->body = $body;
        $this->contentType = $contentType ?? 'text';
    }

    public function createBlock(): self
    {
        Block::create($this->type,$this->body);
        return $this;
    }

    public static function create(string $type = null,string $body = null): self
    {
        return new self($type, $body);
    }

    public static function addBlocksToPage(NotionPage $page): Collection
    {

        return $page->getBlocks()->map(function ($block){
            return array(
                'object'=> $block->object,
                'type' => $block->type,
                $block->type => [
                    $block->contentType => [
                        [
                            'type'=> $block->contentType,
                            $block->contentType => [
                                'content' => $block->body
                            ]
                        ]

                    ]
                ]
            );

        });
    }

    public function ofContentType($contentType = null): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function ofType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function ofBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getLastEditedTime(): string
    {
        return $this->last_edited_time;
    }

    public function isHasChildren(): bool
    {
        return $this->has_children;
    }

    public function setHasChildren(bool $has_children): void
    {
        $this->has_children = $has_children;
    }

    public function getCreatedTime(): string
    {
        return $this->created_time;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }




}
