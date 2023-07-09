<?php

namespace Pi\Notion\Core\Models;

use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\NotionClient;

class NotionUser extends NotionObject
{
    private string $object;
    private string $name;
    private ?string $email;
    private string $avatarUrl;
    private ?string $type;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function make(string $id): self
    {
        return new static($id);
    }
    public static function index(int $pageSize = 100): NotionPaginator
    {
        $user = new static();

        $user->paginator = new NotionPaginator();

        $response = $user->paginator
            ->setUrl($user->getUrl())
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->setPaginatedClass(new NotionUser)
            ->paginate();

        return $user->paginator->make($response);
    }

    public static function find($id): self
    {
        return (new self($id))->get();
    }

    public function get(): self
    {
        $response = NotionClient::request('get', $this->getUrl());
        return $this->fromResponse($response);
    }

    public static function getBot(): self
    {
        $user = new static();
        $response = NotionClient::request('get', $user->botUrl());
        return $user->fromResponse($response);
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

        if (array_key_exists('bot', $response)) {
            $owner = new NotionUser();
            $owner->type = $response['bot']['owner']['type'] ?? null;
            if ($owner->type) {
                $owner->setOwner($response['bot']);
            }
        }
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
