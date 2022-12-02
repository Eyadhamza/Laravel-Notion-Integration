<?php

namespace Pi\Notion\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Pi\Notion\Core\NotionProperty;
use Pi\Notion\Traits\Notionable;

class User extends Model
{
    use Notionable;
    protected string $notionDatabaseId = '74dc9419bec24f10bb2e65c1259fc65a';

    protected $guarded = [];

    public function mapToNotion(): array
    {
        return [
            'name' => NotionProperty::title(),
            'email' => NotionProperty::email(),
            'password' => NotionProperty::richText('Password'),
        ];
    }
}
