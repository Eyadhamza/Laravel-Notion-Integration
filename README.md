# Laravel & Notion Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pi/notion-wrapper.svg?style=flat-square)](https://packagist.org/packages/pi/notion-wrapper)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/pi/notion-wrapper/run-tests?label=tests)](https://github.com/pi/notion-wrapper/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/pi/notion-wrapper/Check%20&%20fix%20styling?label=code%20style)](https://github.com/pi/notion-wrapper/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pi/notion-wrapper.svg?style=flat-square)](https://packagist.org/packages/pi/notion-wrapper)

---

## About

This package is a laravel wrapper on the REST API provided by notion.so, It saves alot of time by providing clean and
easy to use api for interacting with your notion workspace.

The package provides easy and fluent interface to manipulate pages, databases, users, blocks, and more.

## Installation

You can install the package via composer:

```bash
composer require pi/notion-wrapper
```

## Usage

### Setup Notion workspace

in you .env file you should place your token using:

```dotenv

NOTION_TOKEN  = 'secret_{token}'

```

> For information on how to create your first integration please
> visit: [Notion Create an integration](https://developers.notion.com/docs/create-a-notion-integration)
>
> To get your secret token please visit [Notion API](https://developers.notion.com/docs/authorization)

### Working With Notion Databases

Fetch notion database by id:

- This will return a NotionDatabase object with the following information:
    - Information such as: title, description etc.
    - All the database properties.

```php

use Pi\Notion\Core\NotionDatabase;

$database = NotionDatabase::find('632b5fb7e06c4404ae12065c48280e4c');

```

Create a notion database:

- Creates a database as a subpage in the specified parent page, with the specified properties schema.

```php
  $database = (new NotionDatabase)
            ->setParentPageId('fa4379661ed948d7af52df923177028e')
            ->setTitle('Test Database2')
            ->setProperties([
                NotionProperty::title(),
                NotionProperty::select('Status')->setOptions([
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                NotionProperty::date()
            ])->create();
```

Update a notion database:

- Updates an existing database as specified by the parameters.

```php
  $database = (new NotionDatabase)
            ->setDatabaseId('a5f8af6484334c09b69d5dd5f54b378f')
            ->setProperties([
                NotionProperty::select('Status2')->setOptions([
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                NotionProperty::date('Created')
            ])->update();
```

Query A Database

- Gets a list of Pages contained in the database, filtered and ordered according to the filter conditions and sort
  criteria provided

1. Using one filter only
```php
$database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

$pages = $database->filter(NotionFilter::title('Name')->contains('MMMM'))
            ->query();
```
2. Using multiple filters with AND operator
```php
$pages = $database->filters([
            NotionFilter::groupWithAnd([
                NotionFilter::select('Status')
                    ->equals('Reading'),
                NotionFilter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();
```
3. Using multiple filters with OR operator
```php
$pages = $database->filters([
            NotionFilter::groupWithOr([
                NotionFilter::select('Status')
                    ->equals('Reading'),
                NotionFilter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();
```
4. You can also use Notion compound filters
   - compoundAndGroup takes an array of filters as the first argument and an operator in the second argument
   - The operator in the second argument tells the API how to combine the filters in the first argument
   - So, it will be something like this: Status = 'Reading' OR (Name contains 'MMMM' AND Publisher contains 'A')
   - To understand compund filters better please visit [Notion Compound Filters](https://www.notion.so/help/views-filters-and-sorts)
```php
$response = $database->filters([
            NotionFilter::select('Status')
                ->equals('Reading')
                ->compoundOrGroup([
                    NotionFilter::multiSelect('Publisher')
                        ->contains('A'),
                    NotionFilter::title('Name')
                        ->contains('MMMM')
                ], 'and')
        ])->query();
```
5. Sorting database results
- A sort is a condition used to order the entries returned from a database query.

```php
$pages = $database->sort(NotionSort::property('Name')->ascending())
            ->query();

// you can sort with many properties!
$pages = $database->sort([
            NotionSort::property('Name')->ascending(),
            NotionSort::property('Status')->descending()
        ])->query();

// you can surely apply sorts and filters together!
$pages = $database->sort([
            NotionSort::property('Name')->ascending(),
            NotionSort::property('Status')->descending()
        ])->filters([
            NotionFilter::select('Status')
                ->equals('Reading')
                ->compoundOrGroup([
                    NotionFilter::multiSelect('Publisher')
                        ->contains('A'),
                    NotionFilter::title('Name')
                        ->contains('MMMM')
                ], 'and')
        ])->query();
```


### Dealing with Notion Pages


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [EyadHamza](https://github.com/Eyadhamza)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


