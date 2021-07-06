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

```


### Dealing with notion databases

Get a notion database using id

```php

use Pi\Notion\NotionDatabase;

$object = NotionDatabase::ofId('834b5c8cc1204816905cd54dc2f3341d');

```

Query the notion database contents using a specific select filter and value

```php


```


Query the notion database contents using a multiple select filters and values

```php


```

### Dealing with Notion Pages

Get a notion page using id

```php

use Pi\Notion\NotionPage;

$object = NotionPage::ofId('834b5c8cc1204816905cd54dc2f3341d');

```

For Adding a new page

```php

use Pi\Notion\NotionPage;

```


Search a notion page using its title

```php

use Pi\Notion\NotionPage;

$response = (new NotionPage)
            ->search('New Media Article');
            
      
```


Get the blocks (contents) of a notion page using its title

```php

use Pi\Notion\NotionPage;

$page =  (new NotionPage('834b5c8cc1204816905cd54dc2f3341d'))->getBlocks();
      
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
