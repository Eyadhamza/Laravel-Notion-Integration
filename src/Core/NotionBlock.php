<?php


namespace Pi\Notion\Core;


use Illuminate\Support\Collection;
use Pi\Notion\BlockType;
use Pi\Notion\Common\BlockContent;
use Pi\Notion\Common\NotionRichText;
use Pi\Notion\Traits\CreateBlockTypes;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionBlock extends NotionObject
{
    use ThrowsExceptions, CreateBlockTypes;

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
    public static function find($id): self
    {
        return (new NotionBlock)->setId($id)->get();
    }
    public function get():self
    {
        $response = prepareHttp()->get($this->getUrl());
        $this->throwExceptions($response);
        return $this->build($response->json());
    }

    public function getChildren(): Collection
    {
        $response = prepareHttp()->get(NotionWorkspace::BLOCK_URL . $this->id . '/children');
        $this->throwExceptions($response);
        return $this->buildList($response->json());
    }

    public function create(): Collection
    {
        $response = prepareHttp()->patch($this->getUrl() . '/children', [
            'children' => $this->mapChildren()
        ]);
        $this->throwExceptions($response);
        return (new NotionBlock())->buildList($response->json());
    }

    public function update():self
    {
        $response = prepareHttp()->patch($this->getUrl(), [
            $this->type => $this->contentBody()
        ]);
        $this->throwExceptions($response);

        return $this->build($response->json());
    }

    public function delete(): static
    {
        $response = prepareHttp()->delete($this->getUrl());
        $this->throwExceptions($response);
        return $this->build($response->json());
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
    public function addChildren(array $blocks): self
    {
        collect($blocks)->each(function (NotionBlock $block) {
            $this->children->add($block);
        });
        return $this;
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
    private function getUrl(): string
    {
        return NotionWorkspace::BLOCK_URL . $this->id;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }
}
