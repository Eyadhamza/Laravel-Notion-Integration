<?php

namespace PISpace\Notion\Traits;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

trait HasAnnotations
{
    private Collection $annotations;

    private function buildAnnotations(array $annotations): void
    {
        foreach ($annotations as $key => $value) {
            if ($value) {
                $this->annotations->add([$key => $value]);
            }
        }
    }

    public function bold(): self
    {
        $this->annotations->put('bold', true);
        return $this;
    }

    public function italic(): self
    {
        $this->annotations->put('italic', true);
        return $this;
    }

    public function strikethrough(): self
    {
        $this->annotations->put('strikethrough', true);
        return $this;
    }

    public function underline(): self
    {
        $this->annotations->put('underline', true);
        return $this;
    }

    public function code(): self
    {
        $this->annotations->put('code', true);
        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = [
            'url' => $link
        ];
        return $this;
    }
    public function mention(string $type): self
    {
        $this->mainAttributes = [
            'mention' => [
                'type' => $type
            ]
        ];
        return $this;
    }

    public function equation(): self
    {
        $this->mainAttributes = [
            'equation' => true
        ];
        return $this;
    }

    public function linkPreview($value): self
    {
        $this->mainAttributes = [
            'url' => $value
        ];
        return $this;
    }

    public function color(string $color): self
    {
        $this->mainAttributes = [
            'color' => $color
        ];
        return $this;
    }

    public function getAnnotations(): array|MissingValue
    {
        return $this->annotations->isNotEmpty() ? ['annotations' => $this->annotations->all()] : [];
    }

}
