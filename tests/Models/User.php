<?php

namespace Pi\Notion\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Traits\Notionable;

class User extends Model
{
    use HasFactory;
    use Notionable;
    protected string $notionDatabaseId = '74dc9419bec24f10bb2e65c1259fc65a';

    protected $guarded = [];

    public function mapToNotion(): array
    {
        return [
            'name' => BaseNotionProperty::title(),
            'email' => BaseNotionProperty::email(),
            'password' => BaseNotionProperty::richText('Password'),
        ];
    }
}
