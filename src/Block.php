<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;

class Block extends NotionObject
{

    private string $name;
    private string $content;
    private string $contentLink;
    private string $contentType;
    private string $color;
    private Collection $children;

    public function __construct($name = '', $content = '')
    {
        $this->name = $name;
        $this->content = $content;
        $this->contentType = 'rich_text';
        $this->children = new Collection();
    }

    public static function make(string $type = null, string $body = null): self
    {
        return new self($type, $body);
    }

    public static function mapsBlocksToPage(NotionPage $page): Collection
    {

        return $page->getBlocks()->map(function (Block $block) {
            return array(
                'type' => $block->name,
                $block->name => $block->contentBody(),
            );
        });
    }

    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }
    public function contentLink(string $contentLink): self
    {
        $this->contentLink = $contentLink;
        return $this;
    }
    public static function buildBlock(string $name, array $body): Block
    {
        $block = Block::make($body['type'], $name);

        foreach ($body as $key => $value) {
            $block->$key = $value;
        }

        return $block;
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


    public function addChildren(array $blocks): self
    {
        collect($blocks)->each(function (Block $block) {
            $this->children->add($block);
        });
        return $this;
    }

    private function contentBody(): array
    {
        $body = [];
        if (isset($this->content)) $body['content'] = $this->content;

        if (isset($this->contentLink)) $body['link'] = ['url' => $this->contentLink];

        return [ $this->contentType => [
                [
                    'type' => 'text',
                    'text' => $body,
                ]
            ],
            'color' => $this->color ?? 'default',
            'children' => $this->children->map(function (Block $child) {
                return array(
                    'type' => $child->name,
                    'object' => 'block',
                    $child->name => $child->contentBody()
                );
            })
        ];

    }


}
