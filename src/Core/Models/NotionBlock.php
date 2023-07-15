<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Traits\HasResource;

class NotionBlock extends NotionObject
{
    use HasResource;


    const BLOCK_URL = NotionClient::BASE_URL . '/blocks/';
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

    public static function make(NotionBlockTypeEnum $type = null, NotionContent $blockContent = null): static
    {
        return new self($type, $blockContent);
    }

    public function fromResponse(array $response): self
    {
        parent::fromResponse($response);
        $this->type = NotionBlockTypeEnum::from($response['type']);

        return $this;
    }

    public function find(string $id): self
    {
        $response = NotionClient::make()->get(self::BLOCK_URL . $id);

        return $this->fromResponse($response->json());
    }

    public function getChildren(int $pageSize = 100): NotionPaginator
    {
        return NotionPaginator::make(NotionBlock::class)
            ->setUrl(self::BLOCK_URL . $this->id . '/children')
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->paginate();
    }

    public function createChildren(): NotionPaginator
    {
        return NotionPaginator::make(NotionBlock::class)
            ->setUrl(self::BLOCK_URL . $this->id . '/children')
            ->setMethod('patch')
            ->setBody(['children' => $this->children->map(fn(NotionBlock $block) => $block->resource())->all()])
            ->paginate();
    }


    public function update(string $id): self
    {
        $response = NotionClient::make()->patch(self::BLOCK_URL . $id, $this->resource());

        return $this->fromResponse($response->json());
    }

    public function delete(string $id): static
    {
        $response = NotionClient::make()->delete(self::BLOCK_URL . $id);

        return $this->fromResponse($response->json());
    }


    public function addChildren(array $blocks): self
    {
        collect($blocks)->each(function (NotionBlock $block) {
            $this->children->add($block);
        });
        return $this;
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

    public function toArray(): array
    {
        return [
            'object' => 'block',
            'type' => $this->type->value,
            $this->type->value => $this->blockContent->toArray(),
        ];
    }

}
