<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionFile extends NotionContent
{
    private string $fileType;
    private string $fileUrl;
    private string $expiryTime;

    public static function build(array $response): static
    {
        return (new static())
            ->setName($response['name'])
            ->setFileType($response['type'])
            ->setFileUrl($response['file']['url'])
            ->setExpiryTime($response['file']['expiry_time']);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->value,
            $this->fileType => [
                'url' => $this->fileUrl,
                'expiry_time' => $this->expiryTime ?? new MissingValue(),
            ]
        ];
    }

    public function setFileType(string $fileType): NotionFile
    {
        $this->fileType = $fileType;
        return $this;
    }

    public function setFileUrl(string $fileUrl): NotionFile
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }

    public function setExpiryTime(string $expiryTime): NotionFile
    {
        $this->expiryTime = $expiryTime;
        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::FILE;
        return $this;
    }
}
