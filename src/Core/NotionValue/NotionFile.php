<?php

namespace Pi\Notion\Core\NotionValue;

use Illuminate\Http\Resources\MissingValue;

class NotionFile extends NotionBlockContent
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

    public function toResource(): self
    {
        $this->resource = [
            'name' => $this->value,
            $this->fileType => [
                'url' => $this->fileUrl,
                'expiry_time' => $this->expiryTime ?? new MissingValue(),
            ]
        ];

        return $this;
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

}
