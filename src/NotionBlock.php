<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionBlock extends NotionObject
{
    use ThrowsExceptions;

    private string $name;
    private string|array $content;
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

    public static function build($response): static
    {

        $block = parent::build($response);
        $block->name = $response['type'] ?? null;
        $block->content = $response[$block->name] ?? null;
        return $block;
    }

    public static function make(string $type = null, string|array $content = null): self
    {
        return new self($type, $content);
    }

    public static function mapsBlocksToPage(NotionPage $page): Collection
    {

        return $page->getBlocks()->map(function (NotionBlock $block) {
            return array(
                'type' => $block->name,
                $block->name => $block->contentBody(),
            );
        });
    }

    public function get(mixed $id): Collection
    {
        $response = prepareHttp()->get(Workspace::BLOCK_URL . $id . '/children');

        $this->throwExceptions($response);
        return $this->buildList($response->json());
    }
    public function delete(mixed $id): static
    {
        $response = prepareHttp()->delete(Workspace::BLOCK_URL . $id);

        $this->throwExceptions($response);
        return $this->build($response->json());
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
        return NotionBlock::make(BlockTypes::HEADING_1, $body);
    }

    public static function headingTwo(string $body): self
    {
        return NotionBlock::make(BlockTypes::HEADING_2, $body);
    }

    public static function headingThree(string $body): self
    {
        return NotionBlock::make(BlockTypes::HEADING_3, $body);
    }

    public static function paragraph(string $body): self
    {
        return NotionBlock::make(BlockTypes::PARAGRAPH, $body);
    }

    public static function bulletedList(string $body): self
    {
        return NotionBlock::make(BlockTypes::BULLET_LIST, $body);
    }

    public static function numberedList(string $body): self
    {
        return NotionBlock::make(BlockTypes::NUMBERED_LIST, $body);
    }

    public static function toggle(string $body): self
    {
        return NotionBlock::make(BlockTypes::TOGGLE, $body);
    }

    public static function quote(string $body): self
    {
        return NotionBlock::make(BlockTypes::QUOTE, $body);
    }

    public static function callout(string $body): self
    {
        return NotionBlock::make(BlockTypes::CALLOUT, $body);
    }

    public static function divider(): self
    {
        return NotionBlock::make(BlockTypes::DIVIDER);
    }

    public static function code(string $body): self
    {
        return NotionBlock::make(BlockTypes::CODE, $body);
    }

    public static function childPage(string $body): self
    {
        return NotionBlock::make(BlockTypes::CHILD_PAGE, $body);
    }

    public static function embed(string $body): self
    {
        return NotionBlock::make(BlockTypes::EMBED, $body);
    }

    public static function image(string $body): self
    {
        return NotionBlock::make(BlockTypes::IMAGE, $body);
    }

    public static function video(string $body): self
    {
        return NotionBlock::make(BlockTypes::VIDEO, $body);
    }

    public static function file(string $body): self
    {
        return NotionBlock::make(BlockTypes::FILE, $body);
    }


    public function addChildren(array $blocks): self
    {
        collect($blocks)->each(function (NotionBlock $block) {
            $this->children->add($block);
        });
        return $this;
    }

    private function contentBody(): array
    {
        $body = [];
        if (isset($this->content)) $body['content'] = $this->content;

        if (isset($this->contentLink)) $body['link'] = ['url' => $this->contentLink];

        return [$this->contentType => [
            [
                'type' => 'text',
                'text' => $body,
            ]
        ],
            'color' => $this->color ?? 'default',
            'children' => $this->children->map(function (NotionBlock $child) {
                return array(
                    'type' => $child->name,
                    'object' => 'block',
                    $child->name => $child->contentBody()
                );
            })
        ];

    }


}
