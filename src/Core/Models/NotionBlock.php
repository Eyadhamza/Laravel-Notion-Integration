<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Traits\CreateBlockTypes;
use Pi\Notion\Traits\HasResource;

class NotionBlock extends NotionObject
{
    use CreateBlockTypes, HasResource;

    private ?NotionBlockTypeEnum $type;
    private ?NotionContent $blockContent;
    private string $color;
    private Collection $children;
    public JsonResource $resource;

    public function __construct(NotionBlockTypeEnum $type = null, NotionContent $blockContent = null)
    {
        $this->type = $type;
        $this->blockContent = $blockContent;
        $this->children = new Collection();
    }

    public static function make(NotionBlockTypeEnum $type = null, NotionContent $blockContent = null): self
    {
        return new self($type, $blockContent);
    }

    public function fromResponse(array $response): self
    {
        parent::fromResponse($response);
        $this->type = NotionBlockTypeEnum::tryFrom($response['type']);

        return $this;
    }

    public static function find($id): self
    {
        return NotionBlock::make()
            ->setId($id)
            ->get();
    }

    public function get(): self
    {
        $response = NotionClient::make()
            ->get($this->getUrl());

        return $this->fromResponse($response->json());
    }

    public function getChildren(int $pageSize = 100): NotionPaginator
    {
        return NotionPaginator::make(NotionBlock::class)
            ->setUrl($this->childrenUrl())
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->paginate();
    }

    public function createChildren(): NotionPaginator
    {
        return NotionPaginator::make(NotionBlock::class)
            ->setUrl($this->childrenUrl())
            ->setPageSize(null)
            ->setMethod('patch')
            ->setBody(['children' => $this->children
                ->map(fn(NotionBlock $block) => $block
                    ->buildResource()
                    ->resource
                    ->resolve()
                )->all()
            ])
            ->paginate();
    }


    public function update(): self
    {
        $response = NotionClient::make()->patch($this->getUrl(),$this->buildResource()->resource->resolve());

        return $this->fromResponse($response->json());
    }

    public function delete(): static
    {
        $response = NotionClient::make()->delete($this->getUrl());

        return $this->fromResponse($response->json());
    }


    public function addChildren(array $blocks): self
    {
        collect($blocks)->each(function (NotionBlock $block) {
            $this->children->add($block);
        });
        return $this;
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
