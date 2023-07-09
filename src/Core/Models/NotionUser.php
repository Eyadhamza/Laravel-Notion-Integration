<?php

namespace Pi\Notion\Core\Models;

use Pi\Notion\Core\NotionClient;
use Pi\Notion\Core\Query\NotionPaginator;

class NotionUser extends NotionObject
{
    private string $object;
    private string $name;
    private ?string $email;
    private string $avatarUrl;
    private ?string $type;

    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    public static function make(string $id = null): self
    {
        return new static($id);
    }

    public function index(int $pageSize = 100): NotionPaginator
    {
        return NotionPaginator::make(NotionUser::class)
            ->setUrl($this->getUrl())
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->setPaginatedClass(NotionUser::class)
            ->paginate();

    }

    public function find(): self
    {
        return $this->get();
    }

    public function get(): self
    {
        $response = NotionClient::make()
            ->get($this->getUrl());

        return $this->fromResponse($response->json());
    }

    public function getBot(): self
    {
        $response = NotionClient::make()
            ->get($this->botUrl());

        return $this->fromResponse($response->json());
    }

    public function fromResponse($response): self
    {
        $this->object = $response['object'] ?? null;
        $this->id = $response['id'] ?? null;
        $this->name = $response['name'] ?? null;
        $this->avatarUrl = $response['avatar_url'] ?? null;
        $this->type = $response['type'] ?? null;

        if (array_key_exists('person', $response)) {
            $this->email = $response['person']['email'] ?? null;
        }

        if (empty($response['bot'])) {
            return $this;
        }
        if (empty($response['bot']['owner'])) {
            return $this;
        }
        $this->setOwner($response['bot']);
        return $this;
    }

    private function getUrl(): string
    {
        return NotionClient::BASE_URL . '/users/' . $this->id;
    }

    private function botUrl(): string
    {
        return NotionClient::BASE_URL . '/users/' . 'me';
    }

    private function setOwner($response): void
    {
        match ($response['owner']['type']) {
            'user' => $this->fromResponse($response['owner']),
            'workspace' => $this->name = $response['workspace_name']
        };
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public function getObject(): string
    {
        return $this->object;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
