<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionBlock;

trait HandleBlocks
{


    public function setBlocks(array $blocks): self
    {
        collect($blocks)->map(function ($block) {
            $this->blocks->add($block);
        });

        return $this;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function headingOne(string $body): self
    {
        $this->blocks->add(NotionBlock::headingOne($body));
        return $this;
    }

    public function headingTwo(string $body): self
    {
        $this->blocks->add(NotionBlock::headingTwo($body));
        return $this;
    }

    public function headingThree(string $body): self
    {
        $this->blocks->add(NotionBlock::headingThree($body));
        return $this;
    }

    public function paragraph(string $body): self
    {
        $this->blocks->add(NotionBlock::paragraph($body));
        return $this;
    }

    public function bulletedList(string $body): self
    {
        $this->blocks->add(NotionBlock::bulletedList($body));
        return $this;
    }

    public function numberedList(string $body): self
    {
        $this->blocks->add(NotionBlock::numberedList($body));
        return $this;
    }

    public function toggle(string $body): self
    {
        $this->blocks->add(NotionBlock::toggle($body));
        return $this;
    }

    public function quote(string $body): self
    {
        $this->blocks->add(NotionBlock::quote($body));
        return $this;
    }

    public function callout(string $body): self
    {
        $this->blocks->add(NotionBlock::callout($body));
        return $this;
    }

    public function divider(): self
    {
        $this->blocks->add(NotionBlock::divider());
        return $this;
    }

    public function code(string $body): self
    {
        $this->blocks->add(NotionBlock::code($body));

        return $this;
    }

    public function childPage(string $body): self
    {
        $this->blocks->add(NotionBlock::childPage($body));
        return $this;
    }

    public function embed(string $body): self
    {
        $this->blocks->add(NotionBlock::embed($body));
        return $this;
    }

    public function image(string $body): self
    {
        $this->blocks->add(NotionBlock::image($body));
        return $this;
    }

    public function video(string $body): self
    {
        $this->blocks->add(NotionBlock::video($body));
        return $this;
    }

    public function file(string $body): self
    {
        $this->blocks->add(NotionBlock::file($body));
        return $this;
    }

}
