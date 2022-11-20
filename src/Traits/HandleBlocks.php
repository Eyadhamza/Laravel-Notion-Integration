<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Block;
use Pi\Notion\BlockTypes;

trait HandleBlocks
{


    public function setBlocks(Collection|array $blocks): self
    {
        $blocks = is_array($blocks) ? collect($blocks) : $blocks;

        $blocks->map(function ($block) {
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
        $this->blocks->add(Block::headingOne($body));
        return $this;
    }

    public function headingTwo(string $body): self
    {
        $this->blocks->add(Block::headingTwo($body));
        return $this;
    }

    public function headingThree(string $body): self
    {
        $this->blocks->add(Block::headingThree($body));
        return $this;
    }

    public function paragraph(string $body): self
    {
        $this->blocks->add(Block::paragraph($body));
        return $this;
    }

    public function bulletedList(string $body): self
    {
        $this->blocks->add(Block::bulletedList($body));
        return $this;
    }

    public function numberedList(string $body): self
    {
        $this->blocks->add(Block::numberedList($body));
        return $this;
    }

    public function toggle(string $body): self
    {
        $this->blocks->add(Block::toggle($body));
        return $this;
    }

    public function quote(string $body): self
    {
        $this->blocks->add(Block::quote($body));
        return $this;
    }

    public function callout(string $body): self
    {
        $this->blocks->add(Block::callout($body));
        return $this;
    }

    public function divider(): self
    {
        $this->blocks->add(Block::divider());
        return $this;
    }

    public function code(string $body): self
    {
        $this->blocks->add(Block::code($body));

        return $this;
    }

    public function childPage(string $body): self
    {
        $this->blocks->add(Block::childPage($body));
        return $this;
    }

    public function embed(string $body): self
    {
        $this->blocks->add(Block::embed($body));
        return $this;
    }

    public function image(string $body): self
    {
        $this->blocks->add(Block::image($body));
        return $this;
    }

    public function video(string $body): self
    {
        $this->blocks->add(Block::video($body));
        return $this;
    }

    public function file(string $body): self
    {
        $this->blocks->add(Block::file($body));
        return $this;
    }

}
