# Laravel Notion Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eyadhamza/notion-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/eyadhamza/notion-api-wrapper)
[![Total Downloads](https://img.shields.io/packagist/dt/eyadhamza/notion-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/eyadhamza/notion-api-wrapper)

---

## About

The Laravel Notion Integration package is a wrapper for the REST API provided by Notion.so. It allows for easy
interaction with your Notion workspace, saving you time and effort.

This package provides an easy and fluent interface for manipulating pages, databases, users, blocks, and more.

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

> To create your first integration, please
> visit: [Notion Create an integration](https://developers.notion.com/docs/create-a-notion-integration)
> To obtain your secret token, visit [Notion API](https://developers.notion.com/docs/authorization)

### Handling Notion Databases

#### Fetching Notion Database by ID

To fetch a Notion database by ID, use the `find` method of the `NotionDatabase` class. It will return a `NotionDatabase`
object containing information such as title, description, and all the database properties.

```php
use Pi\Notion\Core\Models\NotionDatabase;

$database = NotionDatabase::make('632b5fb7e06c4404ae12065c48280e4c')->find();
```

#### Creating a Notion Database

To create a Notion database, use the `NotionDatabase` class and set the required parameters such as parent page ID and
properties schema.

```php
use Pi\Notion\Core\Models\NotionDatabase;

$database = NotionDatabase::make()
    ->setParentPageId('fa4379661ed948d7af52df923177028e')
    ->setTitle('Test Database2')
    ->buildProperties([
            NotionTitle::make('Name'),
            NotionSelect::make('Status')->setOptions([
                ['name' => 'A', 'color' => 'red'],
                ['name' => 'B', 'color' => 'green']
            ]),
            NotionDate::make('Date'),
            NotionCheckbox::make('Checkbox'),
            NotionFormula::make('Formula')->setExpression('prop("Name")'),
            NotionRelation::make('Relation')
                ->setDatabaseId($this->databaseId),
            NotionRollup::make('Rollup')
                ->setRollupPropertyName('Name')
                ->setRelationPropertyName('Relation')
                ->setFunction('count'),
            NotionPeople::make('People'),
            NotionMedia::make('Media'),
            NotionEmail::make('Email'),
            NotionNumber::make('Number'),
            NotionPhoneNumber::make('Phone'),
            NotionUrl::make('Url'),
            NotionCreatedTime::make('CreatedTime'),
            NotionCreatedBy::make('CreatedBy'),
            NotionLastEditedTime::make('LastEditedTime'),
            NotionLastEditedBy::make('LastEditedBy'),
    ])
    ->create();
```

#### Updating a Notion Database

To update an existing Notion database, use the `NotionDatabase` class and specify the database ID and updated
properties.

```php
$database = NotionDatabase::make('a5f8af6484334c09b69d5dd5f54b378f')
    ->buildProperties([
        // Specify the updated properties
    ])
    ->update();
```

#### Querying a Database

To query a Notion database and get a list of pages contained within the database, you can apply filters and sorting
criteria using the `query` method.

```php
// Using one filter
$paginated = NotionDatabase::make('632b5fb7e06c4404ae12065c48280e4c')
        ->setFilter(NotionSelect::make('Status')->equals('In Progress'))
        ->query();

// Using multiple filters with AND operator
$pages = $database->setFilters([
    NotionFilter::groupWithAnd([
            NotionSelect::make('Status')->equals('Reading'),
            NotionTitle::make('Name')->equals('MMMM')
        ])
])->query();

// Using multiple filters with OR operator
$pages = $database->setFilters([
    NotionFilter::groupWithOr([
            NotionSelect::make('Status')->equals('Reading'),
            NotionTitle::make('Name')->equals('MMMM')
        ])
])->query();

// Using Notion Compound Filters
$response = $database->setFilters([
    NotionFilter::groupWithOr([
            NotionSelect::make('Status')->equals('Reading'),
            NotionFilter::groupWithAnd([
                NotionTitle::make('Name')->contains('MMMM'),
                NotionTitle::make('Name')->contains('EEEE')
            ])
        ]),
])->query();

// Sorting database results
$pages = $database->sorts(NotionSort::property('Name')->ascending())
    ->query();

// Sort with multiple properties
$pages = $database->setSorts([
            NotionTitle::make('Name')->ascending(),
            NotionDate::make('Date')->descending()
        ])->query();

// Apply sorts and filters together
$pages = $database->setSorts([
            NotionTitle::make('Name')->ascending(),
            NotionDate::make('Date')->descending()
        ])->setFilters([
    NotionFilter::groupWithOr([
            NotionSelect::make('Status')->equals('Reading'),
            NotionTitle::make('Name')->equals('MMMM')
        ])
])->query();
```

### Handling Notion Pages

#### Fetching a Page by ID (without the page contents)

```php
$page = NotionPage::make('b4f8e429038744ca9c8d5afa93ea2edd')->find();
```

#### Fetching a Page by ID (with the page contents)

```php
$page = NotionPage::make('b4f8e429038744ca9c8d5afa93ea2edd')->findWithContent();
```

#### Creating a New Notion Page / Notion Database Item

To create a new Notion page or a new item in a Notion database, you can use the `NotionPage` class and set the required
properties and their values.

```php
$page = NotionPage::make()
     ->setDatabaseId('a5f8af6484334c09b69d5dd5f54b378f')
        ->buildProperties([
            NotionTitle::make('Name')
                ->setTitle('Test'),
            NotionSelect::make('Status')
                ->setSelected('A'),
            NotionDate::make('Date')
                ->setStart('2021-01-01'),
            NotionCheckbox::make('Checkbox')
                ->setChecked(true),
            NotionRelation::make('Relation')
                ->setPageIds(['633fc9822c794e3682186491c50210e6']),
            NotionText::make('Password')
                ->setText('Text'),
            NotionPeople::make('People')
                ->setPeople([
                    NotionUser::make('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f'),
                ]),
            NotionMedia::make('Media')
                ->setFiles([
                    NotionFile::make()
                        ->setFileType('file')
                        ->setRelativeType('external')
                        ->setFileUrl('https://www.google.com'),
                ]),
            NotionEmail::make('Email')
                ->setEmail('eyadhamza0@gmail.com'),
            NotionNumber::make('Number')
                ->setNumber(10),
            NotionPhoneNumber::make('Phone')
                ->setPhoneNumber('+201010101010'),
            NotionUrl::make('Url')
                ->setUrl('https://www.google.com'),
        ])
    ->create();
```

#### Creating a New Notion Page / Notion Database Item with Content

```php
 $page = NotionPage::make()
        ->setDatabaseId($this->databaseId)
        ->buildProperties([
            NotionTitle::make('Name', 'Test'),
            NotionSelect::make('Status')
                ->setSelected('A'),
        ])->setBlockBuilder(
        NotionBlockBuilder::make()
            ->headingOne(NotionRichText::text('Eyad Hamza')
                ->isToggleable()
                ->setBlockBuilder(
                    NotionBlockBuilder::make()
                        ->headingOne(NotionRichText::text('Eyad Hamza')
                            ->bold()
                            ->italic()
                            ->strikethrough()
                            ->underline()
                            ->code()
                            ->color('red')
                        )
                )
                ->bold()
                ->italic()
                ->strikethrough()
                ->underline()
                ->code()
                ->color('red')
            )
            ->headingTwo('Heading 2')
            ->headingThree('Heading 3')
            ->numberedList([
                'Numbered List',
                'asdasd Numbered List'
            ])
            ->bulletedList(['Bullet List'])
            ->paragraph('Paragraph')
            ->toDo(['To Do List'])
            ->toggle('Toggle')
            ->quote('Quote')
            ->divider()
            ->callout('Callout')
            ->image(NotionFile::make()
                ->setFileType('image')
                ->setFileUrl('https://my.alfred.edu/zoom/_images/foster-lake.jpg')
                ->setRelativeType('external')
            )
            ->file(NotionFile::make()
                ->setFileType('file')
                ->setFileUrl('https://www.google.com')
                ->setRelativeType('external')
            )
            ->embed('https://www.google.com')
            ->bookmark('https://www.google.com')
            ->code(NotionRichText::text('echo "Hello World"')->setCodeLanguage('php'))
            ->equation('x^2 + y^2 = z^2')
            ->pdf(NotionFile::make()
                ->setFileType('pdf')
                ->setFileUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                ->setRelativeType('external')
            )
            ->video(NotionFile::make()
                ->setFileType('video')
                ->setFileUrl('https://www.youtube.com/watch?v=xTQ7vhtp23w')
                ->setRelativeType('external')
            )
    )->create();
```

#### Updating a Page Properties

To update the properties of an existing page, create a `NotionPage` object with the page ID, set the updated properties,
and call the `update()` method.

```php
$page = NotionPage::make('b4f8e429038744ca9c8d5afa93ea2edd')
    ->buildProperties([
    // Specify the updated properties
])->update();
```

#### Deleting a Page

To delete a page, create a `NotionPage` object with the page ID and call the `delete()` method.

```php
$page = NotionPage::make('b4f8e429038744ca9c8d5afa93ea2edd')->delete();
```

### Handling Notion Blocks

#### Fetching a Block by ID

To fetch a Notion block by ID, use the `find` method of the `NotionBlock` class.

```php
$block = NotionBlock::make('b4f8e429038744ca9c8d5afa93ea2edd')->find();
```

#### Fetching Block Children

To fetch the children blocks of a Notion block, use the `fetchChildren` method.

```php
$blockChildren = NotionBlock::make('b4f8e429038744ca9c8d5afa93ea2edd')
        ->fetchChildren();
```

#### Updating a Block

To update a Notion block, create a new instance of the `NotionBlock` class, set the updated content, and call
the `update()` method.

```php
$block = NotionBlock::make('62ec21df1f9241ba9954828e0958da69')
        ->setType(NotionBlockTypeEnum::HEADING_1)
        ->setBlockContent(NotionRichText::text('Eyad Hamza'))
        ->update();
```

#### Appending Block Children

To append children blocks to a Notion block, use the `createChildren` method.

```php
$block = NotionBlock::make('62ec21df1f9241ba9954828e0958da69')
     ->setBlockBuilder(
        NotionBlockBuilder::make()
            ->headingTwo(NotionRichText::text('Eyad Hamza')
                ->bold()
                ->setLink('https://www.google.com')
                ->color('red'))
            ->headingThree('Heading 3')
            ->numberedList(['Numbered List'])
            ->bulletedList(['Bullet List'])
    )->createChildren();
```

#### Deleting a Block

To delete a Notion block, use the `delete` method.

```php
$block = NotionBlock::make('62ec21df1f9241ba9954828e0958da69')->delete();
```

### Searching

You can perform searches in Notion pages or databases using the `NotionSearch` class.

#### Searching in Pages

To search for a specific query in Notion pages, use the `inPages` method of the `NotionSearch` class. You can apply
sorting criteria using the `sorts` method.

```php
$response = NotionSearch::inPages('Eyad')
    ->sorts([
            NotionLastEditedTime::make()->ascending(),
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

To retrieve all comments associated with a page or discussion, use the `index` method of the `NotionComment` class.

```php
$comments = NotionComment::make('0b036890391f417cbac775e8b0bba680')->index();
```

#### Creating a New Comment

To create a new comment on a page or discussion, use the `NotionComment` class and set the parent ID and content.

```php
// You can pass a rich text object if you want to format the comment
NotionComment::make()
        ->setDiscussionId('ac803deb7b064cca83067c67914b02b4')
        ->setContent(NotionRichText::make('This is a comment')
            ->color('red')
            ->bold()
            ->italic()
        )
        ->create();

// Or you can pass a string
NotionComment::make()
        ->setParentId('a270ab4fa945449f9284b180234b00c3')
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

To map your Laravel Eloquent models to Notion database items, you can use the `Notionable` trait and implement
the `mapToNotion` method in your model.

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

### Watching a Notion Database

Currently, Notion API does not support webhooks. However, you can use the 'notion:watch' artisan command to watch a
Notion database for changes.
The command will run every specified interval and check for changes in the notion database. If there are any changes, it
will send a post request to your route, so you can handle it accordingly.
You can change the interval and the route in the config file.

This is how you can run the command:

```bash
php artisan notion:watch '02758e48d12244f99552dd4f766a0077'
```

Surely, you can use the command in a cron job to run it every specified interval.

```php
// in app/Console/Kernel.php

protected function schedule(Schedule $schedule): void
{
    $schedule->command(NotionDatabaseWatcher::class, ['02758e48d12244f99552dd4f766a0077'])->everyMinute();
}

```

### Handling Errors

In case of an error, an exception will be thrown with the error message. You can check the exceptions folder or
the `NotionException` class for more information about the exceptions. Please refer to the Notion API documentation for
detailed information about the errors.

## Testing

To run the package tests, use the following command:

```bash
composer test
```

## Changelog

Please see the [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please

see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [EyadHamza](https://github.com/Eyadhamza)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
