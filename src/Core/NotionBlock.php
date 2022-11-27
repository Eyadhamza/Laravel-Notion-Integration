<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use Pi\Notion\BlockType;
use Pi\Notion\Common\BlockContent;
use Pi\Notion\Common\NotionRichText;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionBlock extends NotionObject
{
    use ThrowsExceptions;

    private string $type;
    private BlockContent|null|string $blockContent;
    private string $color;
    private Collection $children;

    public function __construct($type = '', $blockContent = null)
    {
        $this->type = $type;
        $this->blockContent = $blockContent;
        $this->children = new Collection();
    }

    public static function build($response): static
    {

        $block = parent::build($response);
        $block->type = $response['type'] ?? null;
        $block->blockContent = new BlockContent($response[$block->type]);
        return $block;
    }

    public static function make(string $type, BlockContent|string $blockContent = null): self
    {
        $blockContent = is_string($blockContent) ? new BlockContent($blockContent) : $blockContent;
        return new self($type, $blockContent);
    }

    public static function mapsBlocksToPage(NotionPage $page): Collection
    {

        return $page->getBlocks()->map(function (NotionBlock $block) {
            return array(
                'type' => $block->type,
                $block->type => $block->contentBody(),
            );
        });
    }

    public function get():self
    {
        $response = prepareHttp()->get($this->getUrl());

        $this->throwExceptions($response);

        return $this->build($response->json());

    }

    public function getChildren(mixed $id = null): Collection
    {
        $id = $id ?? $this->id;

        $response = prepareHttp()->get(NotionWorkspace::BLOCK_URL . $id . '/children');

        $this->throwExceptions($response);
        return $this->buildList($response->json());
    }

    public function delete(mixed $id = null): static
    {
        $id = $id ?? $this->id;

        $response = prepareHttp()->delete(NotionWorkspace::BLOCK_URL . $id);

        $this->throwExceptions($response);
        return $this->build($response->json());
    }

    public function update():self
    {
        $response = prepareHttp()->patch($this->getUrl(), [
            $this->type => $this->contentBody()
        ]);
        $this->throwExceptions($response);

        return $this->build($response->json());
    }


    public function appendChildren()
    {
        $response = prepareHttp()->patch($this->getUrl() . '/children', [
            'children' => $this->mapChildren()
        ]);
        $this->throwExceptions($response);
        return (new NotionBlock())->buildList($response->json());
    }
    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    public static function headingOne(string|NotionRichText $body): self
    {

        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_1, $body);
    }

    public static function headingTwo(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_2, $body);
    }

    public static function headingThree(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_3, $body);
    }

    public static function paragraph(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::PARAGRAPH, $body);
    }

    public static function bulletedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::BULLETED_LIST, $body);
    }

    public static function numberedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::NUMBERED_LIST, $body);
    }

    public static function toggle(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::TOGGLE, $body);
    }

    public static function quote(string $body): self
    {
        return self::make(BlockType::QUOTE, $body);
    }

    public static function callout(string $body): self
    {
        return self::make(BlockType::CALL_OUT, $body);
    }

    public static function divider(): self
    {
        return self::make(BlockType::DIVIDER);
    }

    public static function code(string $body): self
    {
        return self::make(BlockType::CODE, $body);
    }

    public static function childPage(string $body): self
    {
        return self::make(BlockType::CHILD_PAGE, $body);
    }

    public static function embed(string $body): self
    {
        return self::make(BlockType::EMBED, $body);
    }

    public static function image(string $body): self
    {
        return self::make(BlockType::IMAGE, $body);
    }

    public static function video(string $body): self
    {
        return self::make(BlockType::VIDEO, $body);
    }

    public static function file(string $body): self
    {
        return self::make(BlockType::FILE, $body);
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
        $body[$this->blockContent->getType()] = $this->blockContent->getValue();
        $body['color'] = $this->color ?? 'default';
        if ($this->children->isNotEmpty()) {
            $body['children'] = $this->mapChildren();
        }
        return $body;

    }

    private function getUrl(): string
    {
        return NotionWorkspace::BLOCK_URL . $this->id;
    }

    private function mapChildren(): Collection
    {
        return $this->children->map(function (NotionBlock $child) {
            return array(
                'type' => $child->type,
                'object' => 'block',
                $child->type => $child->contentBody()
            );
        });
    }


}
