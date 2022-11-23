<?php

namespace Pi\Notion;

abstract class NotionObject
{
    protected string $objectType;
    protected string $id;
    protected ?string $title;
    protected ?string $description;
    protected string $url;
    protected string $parentId;
    protected bool $archived;
    protected string $createdTime;
    protected string $lastEditedTime;
    protected NotionUser $lastEditedBy;
    protected ?string $icon;
    protected ?string $cover;

    protected function build($response): static
    {
        $this->objectType = $response['object'];
        $this->id = $response['id'] ?? null;
        $this->title = $response['title'][0]['plain_text'] ?? null;
        $this->description = $response['description']['plain_text'] ?? null;
        $this->url = $response['url'] ?? null;
        $this->parentId = $response['parent']['database_id'] ?? null;
        $this->archived = $response['archived'] ?? null;
        $this->createdTime = $response['created_time'] ?? null;
        $this->lastEditedTime = $response['last_edited_time'] ?? null;
        $this->lastEditedBy = new NotionUser($response['last_edited_by']['id']) ?? null;
        $this->icon = $response['icon'] ?? null;
        $this->cover = $response['cover'] ?? null;

        return $this;
    }

    protected function buildProperties(array $properties): static
    {

        collect($properties)->mapWithKeys(function ($body, $name) {
            return $this->properties->add(Property::build($name, $body));
        });
        return $this;
    }
    protected function buildBlocks(array $blocks): static
    {
        $this->blocks = collect($blocks)->map(function ($block) {
            return Block::build($block);
        });
        return $this;
    }
}
