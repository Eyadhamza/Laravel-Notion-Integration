<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionBlockContent;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Traits\CreateBlockTypes;
use Pi\Notion\Traits\HasResource;

class NotionBlock extends NotionObject
{
    use CreateBlockTypes, HasResource;

    private NotionBlockTypeEnum $type;
    private ?NotionBlockContent $blockContent;
    private string $color;
    private Collection $children;
    public JsonResource $resource;

    public function __construct(NotionBlockTypeEnum $type, NotionBlockContent $blockContent = null)
    {
        $this->type = $type;
        $this->blockContent = $blockContent;
        $this->children = new Collection();
    }

    public static function make(NotionBlockTypeEnum $type, NotionBlockContent $blockContent = null): self
    {
        return new self($type, $blockContent);
    }

    public function fromResponse($response): self
    {
        parent::fromResponse($response);
        $this->type = $response['type'] ?? null;

        return $this;
    }

    public static function find($id): self
    {
        return (new NotionBlock)->setId($id)->get();
    }

    public function get(): self
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

    public function update(): self
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

    public function toArray(): array
    {
        return [
            'object' => 'block',
            'type' => $this->type->value,
            $this->type->value => $this->blockContent->toArray(),
        ];
    }
}
