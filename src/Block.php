<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;

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
    public static function make(string $type = null, string $body = null): self
    {
        return new self($type, $body);
    }

    public static function mapsBlocksToPage(NotionPage $page): Collection
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
    public static function headingOne(string $body): self
    {
        return Block::make(BlockTypes::HEADING_1, $body);
    }
    public static function headingTwo(string $body): self
    {
        return Block::make(BlockTypes::HEADING_2, $body);
    }
    public static function headingThree(string $body): self
    {
        return Block::make(BlockTypes::HEADING_3, $body);
    }
    public static function paragraph(string $body): self
    {
        return Block::make(BlockTypes::PARAGRAPH, $body);
    }
    public static function bulletedList(string $body): self
    {
        return Block::make(BlockTypes::BULLET_LIST, $body);
    }
    public static function numberedList(string $body): self
    {
        return Block::make(BlockTypes::NUMBERED_LIST, $body);
    }
    public static function toggle(string $body): self
    {
        return Block::make(BlockTypes::TOGGLE, $body);
    }
    public static function quote(string $body): self
    {
        return Block::make(BlockTypes::QUOTE, $body);
    }
    public static function callout(string $body): self
    {
        return Block::make(BlockTypes::CALLOUT, $body);
    }
    public static function divider(): self
    {
        return Block::make(BlockTypes::DIVIDER);
    }
    public static function code(string $body): self
    {
        return Block::make(BlockTypes::CODE, $body);
    }
    public static function childPage(string $body): self
    {
        return Block::make(BlockTypes::CHILD_PAGE, $body);
    }
    public static function embed(string $body): self
    {
        return Block::make(BlockTypes::EMBED, $body);
    }
    public static function image(string $body): self
    {
        return Block::make(BlockTypes::IMAGE, $body);
    }
    public static function video(string $body): self
    {
        return Block::make(BlockTypes::VIDEO, $body);
    }
    public static function file(string $body): self
    {
        return Block::make(BlockTypes::FILE, $body);
    }





}
