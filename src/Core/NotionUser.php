<?php

namespace Pi\Notion\Core;

use Pi\Notion\NotionClient;

class NotionUser extends NotionObject
{
    private string $object;
    private string $name;
    private ?string $email;
    private string $avatarUrl;
    private ?string $type;
    private NotionUser $owner;

    public function __construct($id = '')
    {
        $this->id = $id;
    }

    public static function index(int $pageSize = 100): NotionPaginator
    {
        $user = new static();

        $user->paginator = new NotionPaginator();

        $response = $user
            ->paginator
            ->setUrl($user->getUrl())
            ->setMethod('get')
            ->setPageSize($pageSize)
            ->paginate();
        return $user->paginator->make($response, new NotionUser);
    }

    public static function find($id): self
    {
        return (new self($id))->get();
    }

    public function get(): self
    {
        $response = NotionClient::request('get', $this->getUrl());
        return $this->build($response);
    }

    public static function getBot(): self
    {
        $user = new static();
        $response = NotionClient::request('get', $user->botUrl());
        return $user->build($response);
    }

    public static function build($response): static
    {
        $user = new static();
        $user->object = $response['object'] ?? null;
        $user->id = $response['id'] ?? null;
        $user->name = $response['name'] ?? null;
        $user->avatarUrl = $response['avatar_url'] ?? null;
        $user->type = $response['type'] ?? null;

        if (array_key_exists('person', $response)) {
            $user->email = $response['person']['email'] ?? null;
        }

        if (array_key_exists('bot', $response)) {
            $user->owner = new NotionUser();
            $user->owner->type = $response['bot']['owner']['type'] ?? null;
            if ($user->owner->type) {
                $user->owner->setOwner($response['bot']);
            }
        }
        return $user;
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
            'user' => $this->build($response['owner']),
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
