# Laravel Wrapper For Notion.so REST API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pi/notion-wrapper.svg?style=flat-square)](https://packagist.org/packages/pi/notion-wrapper)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/pi/notion-wrapper/run-tests?label=tests)](https://github.com/pi/notion-wrapper/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/pi/notion-wrapper/Check%20&%20fix%20styling?label=code%20style)](https://github.com/pi/notion-wrapper/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pi/notion-wrapper.svg?style=flat-square)](https://packagist.org/packages/pi/notion-wrapper)

---
## About 
This package is a laravel wrapper on the REST API provided by notion.so, It saves alot of time by providing clean and easy to use api for interacting with your notion application
## Installation

You can install the package via composer:

```bash
composer require pi/notion-wrapper
```



You can publish the config file with:
```bash
php artisan vendor:publish --provider="Pi\Notion\NotionServiceProvider" --tag="notion-wrapper-config"
```

This is the contents of the published config file:

```php
return [

];
```

## Usage

### Setup Notion workspace

in you .env file you should place your token using :
```dotenv

NOTION_TOKEN  = 'secret_{token}'

```

### Workspace 

You can get information regarding your workspace

```php

use Pi\Notion\Workspace;

$object = Workspace::workspace();

// returns the information of notion workspace as a array response
```


### Dealing with notion databases

Get a notion database using id

```php

use Pi\Notion\NotionDatabase;

$object = NotionDatabase::ofId('834b5c8cc1204816905cd54dc2f3341d');

// returns the information of notion database as a array response
```

Query the notion database contents using a specific select filter and value

```php

use Pi\Notion\NotionDatabase;

$filter = [
    'property' => 'Status',
    'select' => 'Reading'
    ];
             
$response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->getContents($filter);

// returns the contents of notion database as a array response
```


Query the notion database contents using a multiple select filters and values

```php

use Pi\Notion\NotionDatabase;
use Pi\Notion\Properties\Title;

// defining your filters as property name and the select value 

$filters = new \Illuminate\Support\Collection();


$filters->add(new Title('Status','open'))->add(new Title('Publisher','me'));


// getContents() takes two arguments, the first is the filter/s
// the second is the filter type, can be "and" which means it will return content from "a" and "b" (both must satisfy condition), "or" returns content in a or b  

             
$response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->getContents($filters, filterType: 'and');

// returns the contents of notion database as a array response
```

### Dealing with Notion Pages

Get a notion page using id

```php

use Pi\Notion\NotionPage;

$object = NotionPage::ofId('834b5c8cc1204816905cd54dc2f3341d');

// returns the information of notion page as a array response
```

For Adding a new page 

```php

use Pi\Notion\NotionPage;

$properties = array(
        [
            'name' => 'Name',
            'type' => 'text',
            'content' => 'New Media Article',
        ],
        [
            'name' => 'Status',
            'type' => 'select',
            'select_name' => 'Ready to Start',
            'color' => 'yellow'
        ],
        [
        'name' => 'Publisher',
        'type' => 'select',

        'select_name' => 'The Atlantic',
        'color' => 'red',
        ]);
       
$contents = array(
            [
            'tag_type' => 'heading_2',
            'content_type' => 'text',
            'content' => 'this is my content'
            ],
            [
            'tag_type' => 'paragraph',
            'content_type' => 'text',
            'content' => 'this is my content paragraph'
            ]);

// note that the create() method takes two parameters, $properties which is required to define the specific properties you need to have in your page
// $contents is optional, if you would like content to be added to your created page
// the previous are just one example, you can add any notion specific type
// possible tag_types & content_type are available at notion.so

(new NotionPage)->create('632b5fb7e06c4404ae12065c48280e4c', $properties, $contents);

// returns the information of notion page as a array response
```


Search a notion page using its title

```php

use Pi\Notion\NotionPage;

$response = (new NotionPage)
            ->search('New Media Article');
            
      
// returns the information of notion page as a array response
```


Get the blocks (contents) of a notion page using its title

```php

use Pi\Notion\NotionPage;

$page =  (new NotionPage('834b5c8cc1204816905cd54dc2f3341d'))->getBlocks();
      
// returns the required information page as a array response
```


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
