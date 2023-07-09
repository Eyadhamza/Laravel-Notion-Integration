# Laravel Notion Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eyadhamza/notion-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/eyadhamza/notion-api-wrapper)
[![Total Downloads](https://img.shields.io/packagist/dt/eyadhamza/notion-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/eyadhamza/notion-api-wrapper)

---

## About

This package is a Laravel wrapper for the REST API provided by Notion.so. It provides a clean and easy-to-use API for interacting with your Notion workspace, saving you time and effort.

The package offers an easy and fluent interface for manipulating pages, databases, users, blocks, and more.

## Installation

You can install the package via composer:

```bash
composer require eyadhamza/notion-api-wrapper
```

## Usage

### Setting Up Notion Workspace

In your `.env` file, add your Notion token:

```dotenv
NOTION_TOKEN=secret_{token}
```

> To create your first integration, please visit: [Notion Create an integration](https://developers.notion.com/docs/create-a-notion-integration)
> To obtain your secret token, visit [Notion API](https://developers.notion.com/docs/authorization)

### Handling Notion Databases

#### Fetching Notion Database by ID

To fetch a Notion database by ID, use the `find` method of the `NotionDatabase` class. It will return a `NotionDatabase` object containing information such as title, description, and all the database properties.

```php
use Pi\Notion\Core\Models\NotionDatabase;

$database = NotionDatabase::find('632b5fb7e06c4404ae12065c48280e4c');
```

#### Creating a Notion Database

To create a Notion database, use the `NotionDatabase` class and set the required parameters such as parent page ID and properties schema.

```php
$database = (new NotionDatabase)
    ->setParentPageId('fa4379661ed948d7af52df923177028e')
    ->setTitle('Test Database2')
    ->setProperties([
         NotionTitle::make('Name')->build(),
            NotionSelect::make('Status')->setOptions([
                ['name' => 'A', 'color' => 'red'],
                ['name' => 'B', 'color' => 'green']
            ])->build(),
            NotionDate::make('Date')->build(),
            NotionCheckbox::make('Checkbox')->build(),
            NotionFormula::make('Formula')
                ->setExpression('prop("Name")')
                ->build(),
            NotionRelation::make('Relation')
                ->setDatabaseId($this->databaseId)
                ->build(),
            NotionRollup::make('Rollup')
                ->setRollupPropertyName('Name')
                ->setRelationPropertyName('Relation')
                ->setFunction('count')
                ->build(),
            NotionPeople::make('People')->build(),
            NotionFiles::make('Media')->build(),
            NotionEmail::make('Email')->build(),
            NotionNumber::make('Number')->build(),
            NotionPhoneNumber::make('Phone')->build(),
            NotionUrl::make('Url')->build(),
            NotionCreatedTime::make('CreatedTime')->build(),
            NotionCreatedBy::make('CreatedBy')->build(),
            NotionLastEditedTime::make('LastEditedTime')->build(),
            NotionLastEditedBy::make('LastEditedBy')->build(),
    ])
    ->create();
```

#### Updating a Notion Database

To update an existing Notion database, use the `NotionDatabase` class and specify the database ID and updated properties.

```php
$database = (new NotionDatabase)
    ->setDatabaseId('a5f8af6484334c09b69d5dd5f54b378f')
    ->setProperties([
        // Specify the updated properties
    ])
    ->update();
```

#### Querying a Database

To query a Notion database and get a list of pages contained within the database, you can apply filters and sorting criteria using the `query` method.

##### Using One Filter

```php
$database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

$pages = $database->filter(NotionFilter::title('Name')->contains('MMMM'))
    ->query();
```

##### Using Multiple Filters with AND Operator

```php
$pages = $database->filters([
    NotionFilter::groupWithAnd([
        NotionFilter::select('Status')->equals('Reading'),
        NotionFilter::title('Name')->contains('MMMM')
    ])
])->query();
```

##### Using Multiple Filters with OR Operator

```php
$pages = $database->filters([
    NotionFilter::groupWithOr([
        NotionFilter::select('Status')->equals('Reading'),
        NotionFilter::title('Name')->contains('MMMM')
    ])
])->query();
```

##### Using Notion Compound Filters

```php
$response = $database->filters([
    NotionFilter::select('Status')
        ->equals('Reading')
        ->compoundOrGroup([
            NotionFilter::multiSelect('Publisher')->contains('A'),
            NotionFilter::title('Name')->contains('MMMM')
        ], 'and')
])->query();
```

##### Sorting Database Results

```php
$pages = $database->sorts(NotionSort::property('Name')->ascending())
    ->query();

// Sort with multiple properties
$pages = $database->sorts([
    NotionSort::property('Name')->ascending(),
    NotionSort::property('Status')->descending()
])->query();

// Apply sorts and filters together
$pages = $database->sorts([
    NotionSort::property('Name')->ascending(),
    NotionSort::property('Status')->descending()
])->filters([
    NotionFilter::select('Status')
        ->equals('Reading')
        ->compoundOrGroup([
            NotionFilter::multiSelect('Publisher')->contains('A'),
            NotionFilter::title('Name')->contains('MMMM')
        ], 'and')
])->query();
```

### Handling Notion Pages

#### Fetching a Page by ID (without the page contents)

```php
$page = \Pi\Notion\Core\Models\NotionPage::find('b4f8e429038744ca9c8d5afa93ea2edd');
```

#### Fetching a Page by ID (with the page contents)

```php
$page = \Pi\Notion\Core\Models\NotionPage::findContent('b4f8e429038744ca9c8d5afa93ea2edd');
```

#### Creating a New Notion Page / Notion Database Item

To create a new Notion page or a new item in a Notion database, you can use the `NotionPage` class and set the required properties and their values.

```php
$page = new NotionPage();
$page->setDatabaseId($this->notionDatabaseId);
$page->setProperties([
     $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page = $page
        ->setProperties([
            NotionTitle::make('Name')
                ->setTitle('Test')
                ->build(),
            NotionSelect::make('Status')
                ->setSelected('A')
                ->build(),
            NotionDate::make('Date')
                ->setStart('2021-01-01')
                ->build(),
            NotionCheckbox::make('Checkbox')
                ->setChecked(true)
                ->build(),
            NotionRelation::make('Relation')
                ->setPageIds(['633fc9822c794e3682186491c50210e6'])
                ->build(),

            NotionPeople::make('People')
                ->setPeople([
                    new NotionUser('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f')
                ])
                ->build(),
            NotionFiles::make('Media')
                ->setFiles([
                    NotionFile::make('Google')
                        ->setFileType('external')
                        ->setFileUrl('https://www.google.com'),
                    NotionFile::make('Notion')
                        ->setFileType('file')
                        ->setFileUrl('https://s3.us-west-2.amazonaws.com/secure.notion-static.com/7b8b0713-dbd4-4962-b38b-955b6c49a573/My_test_image.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Credential=AKIAT73L2G45EIPT3X45%2F20221024%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20221024T205211Z&X-Amz-Expires=3600&X-Amz-Signature=208aa971577ff05e75e68354e8a9488697288ff3fb3879c2d599433a7625bf90&X-Amz-SignedHeaders=host&x-id=GetObject')
                        ->setExpiryTime('2022-10-24T22:49:22.765Z'),
                ])
                ->build(),
            NotionEmail::make('Email')
                ->setEmail('eyadhamza0@gmail.com')
                ->build(),
            NotionNumber::make('Number')
                ->setNumber(10)
                ->build(),
            NotionPhoneNumber::make('Phone')
                ->setPhoneNumber('+201010101010')
                ->build(),
            NotionUrl::make('Url')
                ->setUrl('https://www.google.com')
                ->build(),
        ])
    ->create();
```

#### Updating a Page Properties

To update the properties of an existing page, create a `NotionPage` object with the page ID, set the updated properties, and call the `update()` method.

```php
$page = new NotionPage('b4f8e429038744ca9c8d5afa93ea2edd');
$page->setProperties([
    // Specify the updated properties
])->update();
```

#### Deleting a Page

To delete a page, create a `NotionPage` object with the page ID and call the `delete()` method.

```php
$page = new NotionPage('b4f8e429038744ca9c8d5afa93ea2edd');
$page->delete();
```

### Handling Notion Blocks

#### Fetching a Block by ID

To

fetch a Notion block by ID, use the `find` method of the `NotionBlock` class.

```php
$block = NotionBlock::find('b4f8e429038744ca9c8d5afa93ea2edd');
```

#### Fetching Block Children

To fetch the children blocks of a Notion block, use the `getChildren` method.

```php
$block = NotionBlock::find('b4f8e429038744ca9c8d5afa93ea2edd');
$children = $block->getChildren();
```

#### Updating a Block

To update a Notion block, create a new instance of the `NotionBlock` class, set the updated content, and call the `update()` method.

```php
$block = NotionBlock::headingOne('This is a paragraph')
    ->setId($this->notionBlockId)
    ->update();
```

#### Appending Block Children

To append children blocks to a Notion block, use the `addChildren` method.

```php
$block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

$block = $block->addChildren([
    NotionBlock::headingTwo('Eyad Hamza'),
    NotionBlock::headingThree('Heading 3'),
    NotionBlock::numberedList('Numbered List'),
    NotionBlock::bulletedList('Bullet List'),
])->create();
```

#### Deleting a Block

To delete a Notion block, use the `delete` method.

```php
$block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');
$block->delete();
```

### Searching

You can perform searches in Notion pages or databases using the `NotionSearch` class.

#### Searching in Pages

To search for a specific query in Notion pages, use the `inPages` method of the `NotionSearch` class. You can apply sorting criteria using the `sorts` method.

```php
$response = NotionSearch::inPages('Eyad')
    ->sorts([
        NotionSort::make('last_edited_time', 'descending')
    ])
    ->apply(50);
```

#### Searching in Databases

To search for a specific query in Notion databases, use the `inDatabases` method of the `NotionSearch` class.

```php
$response = NotionSearch::inDatabases('Eyad')->apply(50);
```

### Users

#### Retrieving All Users

To retrieve all Notion users, use the `index` method of the `NotionUser` class.

```php
$users = NotionUser::make()->index();
```

#### Retrieving a User by ID

To retrieve a specific Notion user by ID, use the `find` method of the `NotionUser` class.

```php
$user = NotionUser::make('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f')->find();
```

#### Retrieving Current Bot Info

To retrieve information about the current Notion bot, use the `getBot` method of the `NotionUser` class.

```php
$bot = NotionUser::make()->getBot();
```

### Comments

#### Retrieving All Comments by Page ID / Discussion ID

To retrieve all comments associated with a page or discussion, use the `findAll` method of the `NotionComment` class.

```php
$comments = NotionComment::make('0b036890391f417cbac775e8b0bba680')->findAll();
```

#### Creating a New Comment

To create a new comment on a page or discussion, use the `NotionComment` class and set the parent ID and content.

```php
$comment = new NotionComment();
$comment->setParentId('a270ab4fa945449f9284b180234b00c3')
    ->setContent('This is a comment')
    ->create();
```

### Pagination

Notion API provides paginated responses for certain endpoints. The `NotionPaginator` class handles pagination for you.

#### Example with Search Results

```php
$response = NotionSearch::inPages('Eyad')->apply(50);
$pages = $response->getResults(); // Get the first 50 results
$response->hasMore(); // Check if there are more results
$response->next() // Get the next 50 results (if hasMore is true)
$response->getObjectType(); // Get the type of the object (always "list")
$response->getResultsType() // Get the type of the results (Block/Database/Page)
```

### Mapping Eloquent Models to Notion Database Items

To map your Laravel Eloquent models to Notion database items, you can use the `Notionable` trait and implement the `mapToNotion` method in your model.

```php
class User extends Model
{
    use Notionable;

    protected string $notionDatabaseId = '74dc9419bec24f10bb2e65c1259fc65a';

    protected $guarded = [];

    public function mapToNotion(): array
    {
        return [
            'name' => NotionTitle::make('Name'),
            'email' => NotionEmail::make('Email'),
            'password' => NotionText::make('Password'),
        ];
    }
}

$user = User::create([
    'name' => 'John Doe',
    'email' => 'johndoe@gmail.com',
    'password' => 'password'
]);

$user->saveToNotion();
```

### Syncing Data between Notion and Eloquent Models

You can sync data between Notion and Eloquent models using the `sync:to-notion` Artisan command.

```bash
php artisan sync:to-notion User
```

### Handling Errors

In case of an error, an exception will be thrown with the error message. You can check the exceptions folder or the `NotionException` class for more information about the exceptions. Please refer to the Notion API documentation for detailed information about the errors.

## Testing

To run the package tests, use the following command:

```bash
composer test
```

## Changelog

Please see the [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [EyadHamza](https://github.com/Eyadhamza)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
