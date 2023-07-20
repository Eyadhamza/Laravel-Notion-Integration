<?php


namespace Pi\Notion\Core\Models;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Traits\HasChildren;
use Pi\Notion\Traits\HasResource;

class NotionBlock extends NotionObject
{
    use HasChildren;
    const BLOCK_URL = NotionClient::BASE_URL . '/blocks/';
    private ?NotionBlockTypeEnum $type;
    private ?NotionContent $value;
    private string $color;
    private Collection $children;

    public function __construct(string $id = null)
    {
        parent::__construct($id);
        $this->children = new Collection();
    }

    public function fromResponse(array $response): self
    {
        parent::fromResponse($response);
        $this->type = NotionBlockTypeEnum::from($response['type']);

        return $this;
    }

    public function find(): self
    {
        $response = NotionClient::make()->get(self::BLOCK_URL . $this->id);

        return $this->fromResponse($response->json());
    }

    public function fetchChildren(int $pageSize = 100): NotionPaginator
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
            ->setBody(['children' => $this->getChildren()])
            ->paginate();
    }


    public function update(): self
    {
        $response = NotionClient::make()->patch(self::BLOCK_URL . $this->id, $this->value->resource());

        return $this->fromResponse($response->json());
    }

    public function delete(): static
    {
        $response = NotionClient::make()->delete(self::BLOCK_URL . $this->id);

        return $this->fromResponse($response->json());
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


    public function setType(?NotionBlockTypeEnum $type): NotionBlock
    {
        $this->type = $type;
        return $this;
    }

    public function setBlockContent(?NotionContent $blockContent): NotionBlock
    {
        $this->value = $blockContent->setBlockType($this->type);

        return $this;
    }

}
