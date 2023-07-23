<?php

namespace PISpace\Notion\Core\Models;

use PISpace\Notion\Core\NotionClient;
use PISpace\Notion\Core\Query\NotionPaginator;

class NotionUser extends NotionObject
{
    const USERS_URL = NotionClient::BASE_URL . '/users/';
    const BOT_URL = NotionClient::BASE_URL . '/users/' . 'me';
    private ?string $object;
    private ?string $name;
    private ?string $email;
    private ?string $avatarUrl;
    private ?string $type;

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

    public function index(int $pageSize = 100): NotionPaginator
    {
        return NotionPaginator::make(NotionUser::class)
            ->setUrl(self::USERS_URL)
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->paginate();

    }

    public function find(): self
    {
        $response = NotionClient::make()->get(self::USERS_URL . $this->id);

        return $this->fromResponse($response->json());
    }

    public function findBot(): self
    {
        $response = NotionClient::make()->get(self::BOT_URL);

        return $this->fromResponse($response->json());
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

    public function getObjectType(): string
    {
        return $this->objectType;
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

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
