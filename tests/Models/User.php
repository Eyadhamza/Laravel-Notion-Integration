<?php

namespace PISpace\Notion\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PISpace\Notion\Core\Properties\BaseNotionProperty;
use PISpace\Notion\Core\Properties\NotionEmail;
use PISpace\Notion\Core\Properties\NotionText;
use PISpace\Notion\Core\Properties\NotionTitle;
use PISpace\Notion\Traits\Notionable;

class User extends Model
{
    use HasFactory;
    use Notionable;
    protected $guarded = [];

    private string $notionDatabaseId = 'ae4c13cd00394938b2f7914cb00350f8';

    public function mapToNotion(): array
    {
        return [
            'name' => NotionTitle::make('Name'),
            'email' => NotionEmail::make('Email'),
            'password' => NotionText::make('Password'),
        ];
    }

}
