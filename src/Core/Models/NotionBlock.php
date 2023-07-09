<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\NotionClient;
use Pi\Notion\Traits\CreateBlockTypes;

class NotionBlock extends NotionObject
{
    use CreateBlockTypes;

    private string $type;
    private ?NotionBlockContent $blockContent = null;
    private string $color;
    private Collection $children;

    public function __construct($type = '', $block = null)
    {
        $this->type = $type;
        $this->block = $block;
        $this->children = new Collection();

    }
    public static function find($id): self
    {
        return (new NotionBlock)->setId($id)->get();
    }
    public function get():self
    {
        $response = NotionClient::request('get', $this->getUrl());

        return $this->fromResponse($response);
    }

    public function getChildren(int $pageSize = 100): NotionPaginator
    {
        $this->paginator = new NotionPaginator();
        $response = $this->paginator
            ->setUrl($this->childrenUrl())
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->paginate();

        return $this->paginator->make($response, $this);
    }

    public function createChildren(int $pageSize = 100): NotionPaginator
    {
        $this->paginator = new NotionPaginator();
        $response = $this->paginator
            ->setUrl($this->childrenUrl())
            ->setMethod('patch')
            ->setRequestBody(['children' => $this->mapChildren()])
            ->paginate();

        return $this->paginator->make($response, $this);
    }

    public function update():self
    {
        $response = NotionClient::request('patch', $this->getUrl(), [
            $this->type => $this->contentBody()
        ]);
        return $this->fromResponse($response);
    }

    public function delete(): static
    {
        $response = NotionClient::make()->delete($this->getUrl());

        return $this->fromResponse($response->json());
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
        $body[$this->block->getType()] = $this->block->getValue();
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

    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->type = $response['type'] ?? null;

        return $this;
    }
    public static function make(string $type, NotionBlock|string $blockContent = null): self
    {
        $blockContent = is_string($blockContent) ? new NotionBlock($blockContent) : $blockContent;
        return new self($type, $blockContent);
    }
    private function getUrl(): string
    {
        return NotionClient::BLOCK_URL . $this->id;
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

    private function childrenUrl(): string
    {
        return NotionClient::BLOCK_URL . $this->id . '/children';
    }
}
